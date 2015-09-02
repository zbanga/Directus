<?php
$app->map("/$v/tables/:table/rows/bulk?", function ($table) use ($acl, $ZendDb, $params, $requestPayload, $app) {
    $TableGateway = new TableGateway($acl, $table, $ZendDb);

    $activityLoggingEnabled = !(isset($_GET['skip_activity_log']) && (1 == $_GET['skip_activity_log']));
    $activityMode = $activityLoggingEnabled ? TableGateway::ACTIVITY_ENTRY_MODE_PARENT : TableGateway::ACTIVITY_ENTRY_MODE_DISABLED;

    switch($app->request()->getMethod()) {
        case 'DELETE':
            $TableGateway->manageRecordUpdate($table, $data, $activityMode);
            break;
        default:
            // @TODO: would be great to make a single sql statement 
            foreach($requestPayload as $data) {
                $TableGateway->manageRecordUpdate($table, $data, $activityMode);
            }
    }

    $entries = $TableGateway->getEntries($params);
    JsonView::render($entries);
})->via('PATCH', 'PUT', 'DELETE');