<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Models\SupportAttachment;
use Viserlab\Models\SupportMessage;
use Viserlab\Models\SupportTicket;

class SupportTicketController extends Controller
{

    public function index()
    {
        $pageTitle = 'Support Tickets';
        $items     = SupportTicket::orderBy('id', 'desc')->paginate(20);
        $this->view('admin/support/ticket', compact('pageTitle', 'items'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Tickets';
        $items     = SupportTicket::whereIn('status', [0, 2])->orderBy('id', 'desc')->paginate(20);
        $this->view('admin/support/ticket', compact('pageTitle', 'items'));
    }

    public function closed()
    {
        $pageTitle = 'Closed Tickets';
        $items     = SupportTicket::where('status', 3)->orderBy('id', 'desc')->paginate(20);
        $this->view('admin/support/ticket', compact('pageTitle', 'items'));
    }

    public function answered()
    {
        $pageTitle = 'Answered Tickets';
        $items     = SupportTicket::where('status', 1)->orderBy('id', 'desc')->paginate(20);
        $this->view('admin/support/ticket', compact('pageTitle', 'items'));
    }

    public function viewTicket()
    {
        $request   = new Request();
        $pageTitle = 'Reply Ticket';
        $ticket    = SupportTicket::where('id', $request->id)->first();
        $messages  = SupportMessage::where('support_ticket_id', $ticket->id)->orderBy('id', 'desc')->get();
        return $this->view('admin/support/reply', compact('ticket', 'messages', 'pageTitle'));
    }

    public function reply()
    {
        global $user_ID;
        $request = new Request();
        $request->validate([
            'message' => 'required'
        ]);
        $ticket             = SupportTicket::where('id', $request->id)->first();
        $message            = new SupportMessage();
        $ticket->status     = 1;
        $ticket->last_reply = current_time('mysql');
        $ticket->save();
        $message->support_ticket_id = $ticket->id;
        $message->admin_id          = $user_ID;
        $message->message           = $request->message;
        $message->save();

        if ($request->hasFile('attachments')) {
            $uploadAttachments = $this->storeSupportAttachments($message->id, $request);
            if ($uploadAttachments != 200) {
                viser_set_notify($uploadAttachments);
                viser_back();
            }
        }

        $user = get_userdata( $ticket->user_id );
        viser_notify($user, 'ADMIN_SUPPORT_REPLY', [
            'ticket_id' => $ticket->ticket,
            'ticket_subject' => $ticket->subject,
            'reply' => $request->message,
            'link' => viser_route_link('user.ticket.view').'?id='.$ticket->ticket,
        ]);

        $notify[] = ['success', 'Support ticket replied successfully!'];
        viser_back($notify);
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
                $notify[] = ['error', 'File could not upload'];
                return $notify;
            }
        }

        return 200;
    }

    public function delete()
    {
        $request = new Request();
        $message = SupportMessage::find($request->id);
        if (!$message) {
            viser_abort(404);
        }
        $path = viser_file_path('ticket');
        if (count(viser_support_ticket_attachments($message->id)) > 0) {
            foreach ($message->attachments as $attachment) {
                viser_file_manager()->removeFile($path . '/' . $attachment->attachment);
                $attachment->delete();
            }
        }
        $message->delete();
        $notify[] = ['success', "Support ticket deleted successfully"];
        viser_back($notify);
    }

    public function close()
    {
        $request = new Request();
        $ticket = SupportTicket::where('id', $request->id)->first();
        $ticket->status = 3;
        $ticket->save();
        $notify[] = ['success', 'Support ticket closed successfully!'];
        viser_back($notify);
    }

    public function download()
    {
        $request = new Request();
        $id = viser_decrypt($request->id);
        $attachment = SupportAttachment::find($id);
        if (!$attachment) {
            viser_abort(404);
        }
        $file = $attachment->attachment;
        $path = viser_file_path('ticket');
        $full_path = $path . '/' . $file;
        $title = sanitize_file_name(get_bloginfo('name') . '-' . $file);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        ob_clean();
        flush();
        return readfile($full_path);
    }
}
