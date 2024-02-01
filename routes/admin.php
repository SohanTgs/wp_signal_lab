<?php

use Viserlab\BackOffice\Router\Router;
use Viserlab\Controllers\Admin\AdminController;
use Viserlab\Controllers\Admin\AutomaticGatewayController;
use Viserlab\Controllers\Admin\DepositController;
use Viserlab\Controllers\Admin\ExtensionController;
use Viserlab\Controllers\Admin\GeneralSettingController;
use Viserlab\Controllers\Admin\ManualGatewayController;
use Viserlab\Controllers\Admin\NotificationController;
use Viserlab\Controllers\Admin\ReportController;
use Viserlab\Controllers\Admin\SupportTicketController;
use Viserlab\Controllers\Admin\UserController;
use Viserlab\Controllers\Admin\ReferralController;
use Viserlab\Controllers\Admin\PackageController;
use Viserlab\Controllers\Admin\SignalController;

$router = new Router;

$router->router([
    'admin.viserlab' => [
        'method'       => 'get',
        'query_string' => 'viserlab',
        'middleware'   =>['checkPlugin'],
        'action'       => [AdminController::class,'dashboard'],
    ],
    'admin.download.attachment'=>[
        'method'       => 'get',
        'query_string' => 'download_attachment',
        'middleware'   =>['checkPlugin'],
        'action'       => [AdminController::class, 'download'],
    ],

    //payment gateway
    'admin.gateway.automatic' => [
        'method'       => 'get',
        'query_string' => 'automatic_gateway_index',
        'middleware'   =>['checkPlugin'],
        'action'       => [AutomaticGatewayController::class, 'index'],
    ],
    'admin.gateway.automatic.status' => [
        'method'       => 'post',
        'query_string' => 'automatic_gateway_automatic_status',
        'middleware'   =>['checkPlugin'],
        'action'       => [AutomaticGatewayController::class, 'status'],
    ],
    'admin.gateway.automatic.edit' => [
        'method'       => 'get',
        'query_string' => 'automatic_gateway_automatic_edit',
        'middleware'   =>['checkPlugin'],
        'action'       => [AutomaticGatewayController::class, 'edit'],
    ],
    'admin.gateway.automatic.update' => [
        'method'       => 'post',
        'query_string' => 'automatic_gateway_automatic_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [AutomaticGatewayController::class, 'update'],
    ],
    'admin.gateway.automatic.currency.remove' => [
        'method'       => 'post',
        'query_string' => 'automatic_gateway_currency_remove',
        'middleware'   =>['checkPlugin'],
        'action'       => [AutomaticGatewayController::class, 'currencyRemove'],
    ],
    'admin.gateway.manual' => [
        'method'       => 'get',
        'query_string' => 'manual_gateway_index',
        'middleware'   =>['checkPlugin'],
        'action'       => [ManualGatewayController::class, 'index'],
    ],
    'admin.gateway.manual.create' => [
        'method'       => 'get',
        'query_string' => 'manual_gateway_create',
        'middleware'   =>['checkPlugin'],
        'action'       => [ManualGatewayController::class, 'create'],
    ],
    'admin.gateway.manual.store' => [
        'method'       => 'post',
        'query_string' => 'manual_gateway_store',
        'middleware'   =>['checkPlugin'],
        'action'       => [ManualGatewayController::class, 'store'],
    ],
    'admin.gateway.manual.edit' => [
        'method'       => 'get',
        'query_string' => 'manual_gateway_edit',
        'middleware'   =>['checkPlugin'],
        'action'       => [ManualGatewayController::class, 'edit'],
    ],
    'admin.gateway.manual.update' => [
        'method'       => 'post',
        'query_string' => 'manual_gateway_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [ManualGatewayController::class, 'update'],
    ],
    'admin.gateway.manual.status' => [
        'method'       => 'post',
        'query_string' => 'manual_gateway_status',
        'middleware'   =>['checkPlugin'],
        'action'       => [ManualGatewayController::class, 'status'],
    ],

    //deposit
    'admin.deposit.pending' => [
        'method'       => 'get',
        'query_string' => 'deposit_pending',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class,'pending'],
    ],
    'admin.deposit.approved' => [
        'method'       => 'get',
        'query_string' => 'deposit_approved',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class,'approved'],
    ],
    'admin.deposit.successful' => [
        'method'       => 'get',
        'query_string' => 'deposit_successful',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class,'successful'],
    ],
    'admin.deposit.rejected' => [
        'method'       => 'get',
        'query_string' => 'deposit_rejected',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class,'rejected'],
    ],
    'admin.deposit.initiated' => [
        'method'       => 'get',
        'query_string' => 'deposit_initiated',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class,'initiated'],
    ],
    'admin.deposit.list' => [
        'method'       => 'get',
        'query_string' => 'deposit_list',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class, 'deposit'],
    ],
    'admin.deposit.details' => [
        'method'       => 'get',
        'query_string' => 'deposit_details',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class, 'detail'],
    ],
    'admin.deposit.approve' => [
        'method'       => 'post',
        'query_string' => 'deposit_approve',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class, 'approve'],
    ],
    'admin.deposit.reject' => [
        'method'       => 'post',
        'query_string' => 'deposit_reject',
        'middleware'   =>['checkPlugin'],
        'action'       => [DepositController::class, 'reject'],
    ],

    //Ticket
    'admin.ticket.index' => [
        'method'       => 'get',
        'query_string' => 'ticket_index',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'index'],
    ],
    'admin.ticket.pending' => [
        'method'       => 'get',
        'query_string' => 'ticket_pending',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'pending'],
    ],
    'admin.ticket.closed' => [
        'method'       => 'get',
        'query_string' => 'ticket_closed',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'closed'],
    ],
    'admin.ticket.answered' => [
        'method'       => 'get',
        'query_string' => 'ticket_answered',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'answered'],
    ],
    'admin.ticket.view' => [
        'method'       => 'get',
        'query_string' => 'ticket_view',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'viewTicket'],
    ],
    'admin.ticket.reply' => [
        'method'       => 'post',
        'query_string' => 'ticket_reply',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'reply'],
    ],
    'admin.ticket.delete' => [
        'method'       => 'post',
        'query_string' => 'ticket_delete',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'delete'],
    ],
    'admin.ticket.close' => [
        'method'       => 'post',
        'query_string' => 'ticket_close',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'close'],
    ],
    'admin.ticket.download' => [
        'method'       => 'get',
        'query_string' => 'ticket_download',
        'middleware'   =>['checkPlugin'],
        'action'       => [SupportTicketController::class, 'download'],
    ],

    //report
    'admin.report.transaction' => [
        'method'       => 'get',
        'query_string' => 'report_transaction',
        'middleware'   =>['checkPlugin'],
        'action'       => [ReportController::class, 'transaction'],
    ],
    'admin.report.notification.history' => [
        'method'       => 'get',
        'query_string' => 'report_notification_history',
        'middleware'   =>['checkPlugin'],
        'action'       => [ReportController::class, 'notificationHistory'],
    ],
    'admin.report.signal.history' => [
        'method'       => 'get',
        'query_string' => 'report_signal_history',
        'middleware'   =>['checkPlugin'],
        'action'       => [ReportController::class, 'signalHistory'],
    ],

    //setting
    'admin.setting.index' => [
        'method'       => 'get',
        'query_string' => 'setting_index',
        'middleware'   =>['checkPlugin'],
        'action'       => [GeneralSettingController::class, 'index'],
    ],
    'admin.setting.store' => [
        'method'       => 'post',
        'query_string' => 'setting_store',
        'middleware'   =>['checkPlugin'],
        'action'       => [GeneralSettingController::class, 'store'],
    ],
    'admin.setting.system.configuration' => [
        'method'       => 'get',
        'query_string' => 'setting_system_configuration',
        'middleware'   =>['checkPlugin'],
        'action'       => [GeneralSettingController::class, 'systemConfiguration'],
    ],
    'admin.setting.system.configuration.store' => [
        'method'       => 'post',
        'query_string' => 'setting_system_configuration_store',
        'middleware'   =>['checkPlugin'],
        'action'       => [GeneralSettingController::class, 'systemConfigurationStore'],
    ],
    'admin.setting.system.configuration.store' => [
        'method'       => 'post',
        'query_string' => 'setting_system_configuration_store',
        'middleware'   =>['checkPlugin'],
        'action'       => [GeneralSettingController::class, 'systemConfigurationStore'],
    ],

    //logo and favicon
    'admin.setting.logo.icon' => [
        'method'       => 'get',
        'query_string' => 'setting_logo_icon',
        'middleware'   =>['checkPlugin'],
        'action'       => [GeneralSettingController::class, 'logoIcon'],
    ],
    'admin.setting.logo.icon.submit' => [
        'method'       => 'post',
        'query_string' => 'setting_logo_icon_submit',
        'middleware'   =>['checkPlugin'],
        'action'       => [GeneralSettingController::class, 'logoIconSubmit'],
    ],

    //notification setting
    'admin.setting.notification.global' => [
        'method'       => 'get',
        'query_string' => 'notification_global',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'global'],
    ],
    'admin.setting.notification.global.update' => [
        'method'       => 'post',
        'query_string' => 'notification_global_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'globalUpdate'],
    ],
    'admin.setting.notification.email' => [
        'method'       => 'get',
        'query_string' => 'email_setting',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'emailSetting'],
    ],
    'admin.setting.notification.email.update' => [
        'method'       => 'post',
        'query_string' => 'email_setting_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'emailSettingUpdate'],
    ],
    'admin.setting.notification.sms' => [
        'method'       => 'get',
        'query_string' => 'sms_setting',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'smsSetting'],
    ],
    'admin.setting.notification.sms.update' => [
        'method'       => 'post',
        'query_string' => 'sms_setting_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'smsSettingUpdate'],
    ],
    'admin.setting.notification.templates' => [
        'method'       => 'get',
        'query_string' => 'template_setting',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'templates'],
    ],
    'admin.setting.notification.template.edit' => [
        'method'       => 'get',
        'query_string' => 'template_edit',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'templateEdit'],
    ],
    'admin.setting.notification.template.update' => [
        'method'       => 'post',
        'query_string' => 'template_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'templateUpdate'],
    ],
    'admin.setting.notification.email.test' => [
        'method'       => 'post',
        'query_string' => 'email_test',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'emailTest'],
    ],
    'admin.setting.notification.sms.test' => [
        'method'       => 'post',
        'query_string' => 'sms_test',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'smsTest'],
    ],
    'admin.setting.notification.telegram' => [
        'method'       => 'get',
        'query_string' => 'telegram_setting',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'telegramSetting'],
    ],
    'admin.setting.notification.telegram.update' => [
        'method'       => 'post',
        'query_string' => 'telegram_setting_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [NotificationController::class, 'telegramSettingUpdate'],
    ],

    //extension
    'admin.extension.index' => [
        'method'       => 'get',
        'query_string' => 'extension_index',
        'middleware'   =>['checkPlugin'],
        'action'       => [ExtensionController::class, 'index'],
    ],
    'admin.extension.update' => [
        'method'       => 'post',
        'query_string' => 'extension_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [ExtensionController::class, 'update'],
    ],
    'admin.extension.status' => [
        'method'       => 'post',
        'query_string' => 'extension_status',
        'middleware'   =>['checkPlugin'],
        'action'       => [ExtensionController::class, 'status'],
    ],

    //bug report and request
    'admin.request.report'=>[
        'method'       => 'get',
        'query_string' => 'report_and_request',
        'middleware'   =>['checkPlugin'],
        'action'       => [AdminController::class,'requestReport'],
    ],
    'admin.request.report.submit'=>[
        'method'       => 'post',
        'query_string' => 'report_and_request_submit',
        'middleware'   =>['checkPlugin'],
        'action'       => [AdminController::class,'requestReportSubmit'],
    ],

    // Manage Users
    'admin.users.all'=>[
        'method'       => 'get',
        'query_string' => 'users_all',
        'middleware'   =>['checkPlugin'],
        'action'       => [UserController::class,'allUsers'],
    ],
    'admin.users.detail'=>[
        'method'       => 'get',
        'query_string' => 'users_detail',
        'middleware'   =>['checkPlugin'],
        'action'       => [UserController::class,'userDetail'],
    ],
    'admin.users.update'=>[
        'method'       => 'post',
        'query_string' => 'users_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [UserController::class,'userUpdate'],
    ],

    // Package
    'admin.package.all'=>[
        'method'       => 'get',
        'query_string' => 'package_all',
        'middleware'   =>['checkPlugin'],
        'action'       => [PackageController::class,'all'],
    ],
    'admin.package.add'=>[
        'method'       => 'post',
        'query_string' => 'package_add',
        'middleware'   =>['checkPlugin'],
        'action'       => [PackageController::class,'add'],
    ],
    'admin.package.update'=>[
        'method'       => 'post',
        'query_string' => 'package_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [PackageController::class,'update'],
    ],
    'admin.package.status'=>[
        'method'       => 'post',
        'query_string' => 'package_status',
        'middleware'   =>['checkPlugin'],
        'action'       => [PackageController::class,'status'],
    ],

    // Signal
    'admin.signal.all'=>[
        'method'       => 'get',
        'query_string' => 'signal_all',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'all'],
    ],
    'admin.signal.sent'=>[
        'method'       => 'get',
        'query_string' => 'signal_sent',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'sent'],
    ],
    'admin.signal.not.send'=>[
        'method'       => 'get',
        'query_string' => 'signal_not_sent',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'notSent'],
    ],
    'admin.signal.add.page'=>[
        'method'       => 'get',
        'query_string' => 'signal_add_page',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'addPage'],
    ],
    'admin.signal.add'=>[
        'method'       => 'post',
        'query_string' => 'signal_add',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'add'],
    ],
    'admin.signal.edit'=>[
        'method'       => 'get',
        'query_string' => 'signal_edit',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'edit'],
    ],
    'admin.signal.update'=>[
        'method'       => 'post',
        'query_string' => 'signal_update',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'update'],
    ],
    'admin.signal.delete'=>[
        'method'       => 'post',
        'query_string' => 'signal_delete',
        'middleware'   =>['checkPlugin'],
        'action'       => [SignalController::class,'delete'],
    ],
]);
