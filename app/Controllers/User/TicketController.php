<?php

namespace Viserlab\Controllers\User;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Models\SupportAttachment;
use Viserlab\Models\SupportMessage;
use Viserlab\Models\SupportTicket;

class TicketController extends Controller
{
    public function myTicket()
    {
        $this->pageTitle = 'Support Tickets';

        global $user_ID;
        $supports = SupportTicket::where('user_id', $user_ID)->orderBy('id', 'desc')->paginate(20);
        $this->view('user/support/index', compact('supports'));
    }

    public function createTicket()
    {
        $pageTitle = 'Open Ticket';
        $this->pageTitle = $pageTitle;

        global $user_ID;
        $user = get_userdata($user_ID);
        $this->view('user/support/create', compact('user', 'pageTitle'));
    }

    public function storeTicket()
    {
        global $user_ID;
        $ticket  = new SupportTicket();
        $message = new SupportMessage();

        $request = new Request();
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'subject'  => 'required',
            'priority' => 'required|in:1,2,3',
            'message'  => 'required',
        ]);

        $ticket->user_id    = $user_ID;
        $ticket->ticket     = rand(100000, 999999);
        $ticket->name       = sanitize_text_field($request->name);
        $ticket->email      = sanitize_email($request->email);
        $ticket->subject    = sanitize_text_field($request->subject);
        $ticket->last_reply = current_time('mysql');
        $ticket->status     = 0;
        $ticket->priority   = intval($request->priority);
        $ticket->save();

        $message->support_ticket_id = $ticket->id;
        $message->message           = sanitize_textarea_field($request->message);
        $message->save();

        if ($request->hasFile('attachments')) {
            $uploadAttachments = $this->storeSupportAttachments($message->id, $request);
            if ($uploadAttachments != 200) {
                viser_set_notify($uploadAttachments);
                viser_back();
            }
        }

        $notify[] = ['success', 'Ticket opened successfully!'];
        viser_redirect(viser_route_link('user.ticket.view') . '?id=' . $ticket->ticket,$notify);
    }

    protected function storeSupportAttachments($messageId, $request)
    {
        $path = viser_file_path('ticket');
        foreach ($request->files('attachments') as  $file) {
            try {
                $attachment                     = new SupportAttachment();
                $attachment->support_message_id = $messageId;
                $attachment->attachment         = viser_file_uploader($file, $path);
                $attachment->save();
            } catch (\Exception $exp) {
                dd($exp->getMessage());
                $notify[] = ['error', 'File could not upload'];
                return $notify;
            }
        }

        return 200;
    }

    public function viewTicket()
    {   
        $pageTitle = 'View Ticket';
        $this->pageTitle = $pageTitle;

        global $user_ID;
        $request  = new Request();
        $user     = get_userdata($user_ID);
        $myTicket = SupportTicket::where('ticket', $request->id)->where('user_id', $user_ID)->first();
        $messages = SupportMessage::where('support_ticket_id', $myTicket->id)->orderBy('id', 'desc')->get();
        if (!$myTicket) {
            viser_abort(404);
        }
        $this->view('user/support/view', compact('myTicket', 'messages', 'user',  'pageTitle'));
    }

    public function closeTicket()
    {
        $request        = new Request();
        $ticket         = SupportTicket::where('id', $request->id)->first();
        $ticket->status = 3;
        $ticket->save();
        $notify[] = ['success', 'Support ticket closed successfully!'];
        viser_back($notify);
    }

    public function replyTicket()
    {
        global $user_ID;
        $request = new Request();
        $request->validate([
            'message' => 'required'
        ]);
        $ticket             = SupportTicket::where('id', $request->id)->where('user_id', $user_ID)->first();
        $message            = new SupportMessage();
        $ticket->status     = 2;
        $ticket->last_reply = current_time('mysql');
        $ticket->save();
        $message->support_ticket_id = $ticket->id;
        $message->message           = sanitize_textarea_field($request->message);
        $message->save();

        if ($request->hasFile('attachments')) {

            $uploadAttachments = $this->storeSupportAttachments($message->id, $request);
            if ($uploadAttachments != 200) {
                viser_set_notify($uploadAttachments);
                viser_back();
            }
        }

        $notify[] = ['success', 'Support ticket replied successfully!'];
        viser_back($notify);
    }

    public function downloadTicket()
    {
        $request    = new Request();
        $id         = viser_decrypt($request->id);
        $attachment = SupportAttachment::find($id);
        if (!$attachment) {
            viser_abort(404);
        }
        $file      = $attachment->attachment;
        $path      = viser_file_path('ticket');
        $full_path = $path . '/' . $file;
        $title     = sanitize_file_name(get_bloginfo('name') . '-' . $file);
        $ext       = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype  = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        ob_clean();
        flush();
        return readfile($full_path);
    }
}
