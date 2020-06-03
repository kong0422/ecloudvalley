<?php
/**
 * Get lineItem/UnblendedCost grouping by product/productname
 * Input
 * Column	Required
 * lineitem/usageaccountid	true
 * Output
 * {
 *  "{product/productname_A}": {
 *    "YYYY/MM/01": "sum(lineItem/UsageAmount)",
 *    "YYYY/MM/02": "sum(lineItem/UsageAmount)",
 *    "YYYY/MM/03": "sum(lineItem/UsageAmount)",
 *    ...
 *   },
 *  "{product/productname_B}": {
 *    "YYYY/MM/01": "sum(lineItem/UsageAmount)",
 *    "YYYY/MM/02": "sum(lineItem/UsageAmount)",
 *    "YYYY/MM/03": "sum(lineItem/UsageAmount)",
 *    ...
 *   },
 * }
 */

set_time_limit(0);
include('../dbconn.php');
include('../function.php');

$method = get($_SERVER, 'REQUEST_METHOD');
if ($method) strtoupper($method);
switch ($method) {

    case 'GET':
        $response = [
            'status' => FALSE,
            'message' => '',
            'data' => [],
        ];

        $page = get($_GET, 'page', 1);
        $limit = get($_GET, 'limit', 10);
        $offset = ($page - 1) * $limit;
        $q = get($_GET, 'q');
        $begin_date = get($_GET, 'begin_date');
        $end_date = get($_GET, 'end_date');
        $UsageAccountId = get($_GET, 'UsageAccountId');

        if (!$UsageAccountId) {
            $response['message'] = '[UsageAccountId] is a required property';
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit;
        }

        $conditions = [];
        if ($UsageAccountId) $conditions[] = "`lineItem/UsageAccountId` = {$UsageAccountId}";
        if ($q) $conditions[] = "`product/ProductName` like '%{$q}%'";

        $sql = "SELECT DISTINCT `product/ProductName` as product FROM `output_mod`";
        foreach ($conditions as $k => $c) {
            if ($k == 0) {
                $sql.= " WHERE {$c}";
            } else {
                $sql.= " AND {$c}";
            }
        }
        $sql.= " LIMIT {$limit} OFFSET  $offset";

        if ($result = $mysqli->query($sql)) {
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $response['data'][$row['product']] = [];
            }
            $result->free();

            foreach ($response['data'] as $ProductName => $row) {
                $conditions = [
                    "`lineItem/UsageAccountId` = {$UsageAccountId}",
                    "`product/ProductName` = '{$ProductName}'",
                ];
                if ($begin_date) $conditions[] = "`lineItem/UsageStartDate` >= '{$begin_date} 00:00:00'";
                if ($end_date) $conditions[] = "`lineItem/UsageEndDate` <= '{$end_date} 23:59:59'";

                // 舊版mysql 使用 DATE_FORMAT 通常會沒辦法使用index查詢，
                // $sql = "SELECT DATE_FORMAT(`lineItem/UsageStartDate`, '%Y-%m-%d') as days, sum(`lineItem/UsageAmount`) as amount FROM `output_mod`";
                $sql = "SELECT `lineItem/UsageStartDate` as days, sum(`lineItem/UsageAmount`) as amount FROM `output_mod`";
                foreach ($conditions as $k => $c) {
                    if ($k == 0) {
                        $sql.= " WHERE {$c}";
                    } else {
                        $sql.= " AND {$c}";
                    }
                }
                $sql.= " GROUP BY `product/ProductName`, days ORDER BY days ASC";
                if ($result = $mysqli->query($sql)) {
                    while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        $days = date('Y-m-d', strtotime($row['days']));
                        $response['data'][$ProductName][$days] = $row['amount'];
                    }
                    $result->free();
                }
            }
            $response['status'] = TRUE;
        }


        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        echo "The page that you have requested could not be found.";

}

$mysqli->close();
exit;
?>
