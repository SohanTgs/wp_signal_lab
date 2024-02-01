<?php

namespace Viserlab\Controllers\Admin;

use Viserlab\BackOffice\Request;
use Viserlab\Controllers\Controller;
use Viserlab\Lib\FormProcessor;
use Viserlab\Models\Form;
use Viserlab\Models\Gateway;
use Viserlab\Models\GatewayCurrency;

class ManualGatewayController extends Controller
{
    public function index()
    {
        $pageTitle = "Manual Gateways";
        $gateways  = Gateway::where('code', '>=', 1000)->orderBy('name', 'asc')->get();
        return $this->view('admin/gateway/manual/list', compact('pageTitle', 'gateways'));
    }

    public function create()
    {
        $pageTitle = "Add Manual Gateway";
        $this->view('admin/gateway/manual/create', compact('pageTitle'));
    }

    public function store()
    {
        $request = new Request();
        $request->validate([
            'name'           => 'required',
            'currency'       => 'required',
            'rate'           => 'required|numeric',
            'min_limit'      => 'required|numeric',
            'max_limit'      => 'required|numeric',
            'fixed_charge'   => 'required|numeric',
            'percent_charge' => 'required|numeric'
        ]);

        $lastMethod = Gateway::where('code', '>=', 1000)->orderBy('id', 'desc')->first();
        $methodCode = 1000;
        if ($lastMethod) {
            $methodCode = $lastMethod->code + 1;
        }

        $formProcessor = new FormProcessor();
        $generate      = $formProcessor->generate('manual_deposit');

        $method                       = new Gateway();
        $method->code                 = $methodCode;
        $method->form_id              = wp_parse_args($generate->id,null) ?? 0;
        $method->name                 = sanitize_text_field($request->name);
        $method->alias                = strtolower(trim(str_replace(' ', '_', sanitize_text_field($request->name))));
        $method->status               = 0;
        $method->gateway_parameters   = json_encode([]);
        $method->supported_currencies = json_encode([]);
        $method->crypto               = 0;
        $method->status               = 1;
        $method->description          = balanceTags(wp_kses($request->instruction, viser_allowed_html()));
        $method->save();

        $gatewayCurrency                 = new GatewayCurrency();
        $gatewayCurrency->name           = sanitize_text_field($request->name);
        $gatewayCurrency->gateway_alias  = strtolower(trim(str_replace(' ', '_', sanitize_text_field($request->name))));
        $gatewayCurrency->currency       = sanitize_text_field($request->currency);
        $gatewayCurrency->symbol         = '';
        $gatewayCurrency->method_code    = $methodCode;
        $gatewayCurrency->min_amount     = sanitize_text_field($request->min_limit);
        $gatewayCurrency->max_amount     = sanitize_text_field($request->max_limit);
        $gatewayCurrency->fixed_charge   = sanitize_text_field($request->fixed_charge);
        $gatewayCurrency->percent_charge = sanitize_text_field($request->percent_charge);
        $gatewayCurrency->rate           = sanitize_text_field($request->rate);
        $gatewayCurrency->save();

        $notify[] = ['success', __('Manual gateway has been added.', VISERLAB_PLUGIN_NAME)];
        viser_back($notify);
    }

    public function edit()
    {
        $request = new Request();
        $method  = Gateway::find($request->id);
        if (!$method) {
            viser_abort(404);
        }
        $pageTitle       = 'Edit Manual Gateway';
        $gatewayCurrency = GatewayCurrency::where('method_code', $method->code)->first();
        $form            = Form::where('id', $method->form_id)->first();
        $this->view('admin/gateway/manual/edit', compact('pageTitle', 'method', 'gatewayCurrency', 'form'));
    }

    public function update()
    {
        $request = new Request();
        $request->validate([
            'name'           => 'required',
            'currency'       => 'required',
            'rate'           => 'required|numeric',
            'min_limit'      => 'required|numeric',
            'max_limit'      => 'required|numeric',
            'fixed_charge'   => 'required|numeric',
            'percent_charge' => 'required|numeric'
        ]);

        $method = Gateway::find($request->id);
        if (!$method) {
            viser_abort(404);
        }

        $formProcessor = new FormProcessor();
        if ($method->form_id) {
            $generate = $formProcessor->generate('manual_deposit', true, 'id', $method->form_id);
        } else {
            $generate = $formProcessor->generate('manual_deposit');
        }

        $method->form_id              = @$generate->id ?? 0;
        $method->name                 = sanitize_text_field($request->name);
        $method->alias                = strtolower(trim(str_replace(' ', '_', sanitize_text_field($request->name))));
        $method->gateway_parameters   = json_encode([]);
        $method->supported_currencies = json_encode([]);
        $method->crypto               = 0;
        $method->description          = balanceTags(wp_kses($request->instruction, viser_allowed_html()));
        $method->save();

        $gatewayCurrency['name']           = sanitize_text_field($request->name);
        $gatewayCurrency['gateway_alias']  = strtolower(trim(str_replace(' ', '_', sanitize_text_field($request->name))));
        $gatewayCurrency['currency']       = sanitize_text_field($request->currency);
        $gatewayCurrency['symbol']         = '';
        $gatewayCurrency['min_amount']     = sanitize_text_field($request->min_limit);
        $gatewayCurrency['max_amount']     = sanitize_text_field($request->max_limit);
        $gatewayCurrency['fixed_charge']   = sanitize_text_field($request->fixed_charge);
        $gatewayCurrency['percent_charge'] = sanitize_text_field($request->percent_charge);
        $gatewayCurrency['rate']           = sanitize_text_field($request->rate);

        GatewayCurrency::where('method_code', $method->code)->update($gatewayCurrency);

        $notify[] = ['success', 'Manual gateway updated successfully.'];
        viser_back($notify);
    }

    public function status()
    {
        $request = new Request();
        $gateway = Gateway::find($request->id);
        if (!$gateway) {
            viser_abort(404);
        }
        $gateway->status = $gateway->status ? 0 : 1;
        $gateway->save();
        $notify[] = ['success', 'Gateway status changed successfully'];
        viser_back($notify);
    }
}
