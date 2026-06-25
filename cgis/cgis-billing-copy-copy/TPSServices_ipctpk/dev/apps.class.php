<?php

class apps {

    var $conn, $CONF;
    var $tableXpi2StrArInvoiceHdr, $tableXpi2StrArInvoiceDtl, $tableXpi2StrArReceipt,
            $tableXpi2StgAp, $tableXpi2StgApSharingStg, $tableXpi2IntegrasiLog, $tableXpi2ApSharingPkg;

    function apps($config, $connection) {
        $this->conn = $connection;
        $this->CONF = $config;
        $this->getTableConfig();
    }

    function getTableConfig() {
        $this->tableXpi2StrArInvoiceHdr = $this->CONF['db.schema'] . 'XPI2_STG_AR_INVOICE_HDR';
        $this->tableXpi2StrArInvoiceDtl = $this->CONF['db.schema'] . 'XPI2_STG_AR_INVOICE_DTL';
        $this->tableXpi2StrArReceipt = $this->CONF['db.schema'] . 'XPI2_STG_AR_RECEIPT';
        $this->tableXpi2StgAp = $this->CONF['db.schema'] . 'XPI2_STG_AP';
        $this->tableXpi2StgApSharingStg = $this->CONF['db.schema'] . 'XPI2_AP_SHARING_STG';
        $this->tableXpi2IntegrasiLog = $this->CONF['db.schema'] . 'XPI2_INTEGRASI_LOG';
        $this->tableXpi2ApSharingPkg = $this->CONF['db.schema'] . 'xpi2_ap_sharing_pkg.populate_sharing_cfscargo';
    }

    function getMessageTransaction($source_system, $transaction_no = "") {
        $message = '';
        if ($transaction_no != "") {
            $SQL = "SELECT TRX_NUMBER, STATUS_NOTA, STATUS_ARMSG 
                    FROM " . $this->tableXpi2StrArInvoiceHdr . " 
                    WHERE STATUS_NOTA IS NOT NULL 
                          AND TRX_NUMBER = '" . $transaction_no . "'
                          AND SOURCE_SYSTEM = '" . $source_system . "'";
        } else {
            $SQL = "SELECT TRX_NUMBER, STATUS_NOTA, STATUS_ARMSG 
                    FROM " . $this->tableXpi2StrArInvoiceHdr . " 
                    WHERE STATUS_NOTA IS NOT NULL 
                          AND FLAG_STATUS = 'N'
                          AND SOURCE_SYSTEM = '" . $source_system . "'";
        }
        $Query = $this->conn->query($SQL);
        if ($Query->size() > 0) {
            while ($Query->next()) {
                $TRX_NUMBER = $Query->get("TRX_NUMBER");
                $STATUS_NOTA = $Query->get("STATUS_NOTA");
                $STATUS_ARMSG = $Query->get("STATUS_ARMSG");
                $message .= '<transaction>';
                $message .= '<transaction_number>' . $TRX_NUMBER . '</transaction_number>';
                $message .= '<status>' . $STATUS_NOTA . '</status>';
                $message .= '<message>' . $STATUS_ARMSG . '</message>';
                $message .= '</transaction>';
                $SQL = "UPDATE " . $this->tableXpi2StrArInvoiceHdr . " 
                        SET FLAG_STATUS = 'Y' 
                        WHERE TRX_NUMBER = '" . $TRX_NUMBER . "'";
                $Execute = $this->conn->execute($SQL);
                if (!$Execute) {
                    $this->conn->rollback();
                    $return['status'] = false;
                    $return['message'] = '';
                    return $return;
                }
            }
            $this->conn->commit();
            $return['status'] = true;
            $return['message'] = $message;
        }
        return $return;
    }

    function getMessageReceipt($source_system, $transaction_no = "") {
        $message = '';
        if ($transaction_no != "") {
            $SQL = "SELECT RECEIPT_NUMBER, STATUS_RECEIPT, STATUS_RECEIPTMSG 
                    FROM " . $this->tableXpi2StrArReceipt . " 
                    WHERE STATUS_RECEIPT IS NOT NULL
                          AND RECEIPT_NUMBER = '" . $transaction_no . "'
                          AND SOURCE_SYSTEM = '" . $source_system . "'";
        } else {
            $SQL = "SELECT RECEIPT_NUMBER, STATUS_RECEIPT, STATUS_RECEIPTMSG 
                    FROM " . $this->tableXpi2StrArReceipt . " 
                    WHERE STATUS_RECEIPT IS NOT NULL
                          AND FLAG_STATUS = 'N'
                          AND SOURCE_SYSTEM = '" . $source_system . "'";
        }
        $Query = $this->conn->query($SQL);
        if ($Query->size() > 0) {
            while ($Query->next()) {
                $RECEIPT_NUMBER = $Query->get("RECEIPT_NUMBER");
                $STATUS_RECEIPT = $Query->get("STATUS_RECEIPT");
                $STATUS_RECEIPTMSG = $Query->get("STATUS_RECEIPTMSG");
                $message .= '<receipt>';
                $message .= '<receipt_number>' . $RECEIPT_NUMBER . '</receipt_number>';
                $message .= '<status>' . $STATUS_RECEIPT . '</status>';
                $message .= '<message>' . $STATUS_RECEIPTMSG . '</message>';
                $message .= '</receipt>';
                $SQL = "UPDATE " . $this->tableXpi2StrArReceipt . " 
                        SET FLAG_STATUS = 'Y' 
                        WHERE RECEIPT_NUMBER = '" . $RECEIPT_NUMBER . "'";
                $Execute = $this->conn->execute($SQL);
                if (!$Execute) {
                    $this->conn->rollback();
                    $return['status'] = false;
                    $return['message'] = '';
                    return $return;
                }
            }
            $this->conn->commit();
            $return['status'] = true;
            $return['message'] = $message;
        }
        return $return;
    }

    function getMessagePayable($source_system, $transaction_no = "") {
        $message = '';
        if ($transaction_no != "") {
            $SQL = "SELECT TRX_NUMBER, STATUS, ERROR_MESSAGE 
                    FROM " . $this->tableXpi2StgApSharingStg . " 
                    WHERE TRX_NUMBER = '" . $TRX_NUMBER . "'
                          AND SOURCE_SYSTEM = '" . $source_system . "'";
        } else {
            $SQL = "SELECT TRX_NUMBER, STATUS, ERROR_MESSAGE 
                    FROM " . $this->tableXpi2StgApSharingStg . " 
                    WHERE TRX_NUMBER = '" . $TRX_NUMBER . "'
                          AND SOURCE_SYSTEM = '" . $source_system . "'";
        }
        $Query = $this->conn->query($SQL);
        if ($Query->size() > 0) {
            while ($Query->next()) {
                $TRX_NUMBER = $Query->get("TRX_NUMBER");
                $STATUS = $Query->get("STATUS");
                $ERROR_MESSAGE = $Query->get("ERROR_MESSAGE");
                $message .= '<payable>';
                $message .= '<transaction_number>' . $TRX_NUMBER . '</transaction_number>';
                $message .= '<status>' . $STATUS . '</status>';
                $message .= '<message>' . $ERROR_MESSAGE . '</message>';
                $message .= '</payable>';
                $SQL = "UPDATE " . $this->tableXpi2StgApSharingStg . " 
                        SET FLAG_STATUS = 'Y' 
                        WHERE TRX_NUMBER = '" . $TRX_NUMBER . "'";
                $Execute = $this->conn->execute($SQL);
                if (!$Execute) {
                    $this->conn->rollback();
                    $return['status'] = false;
                    $return['message'] = '';
                    return $return;
                }
            }
            $this->conn->commit();
            $return['status'] = true;
            $return['message'] = $message;
        }
        return $return;
    }

    function getMessage($source_system, $is_transaction, $is_receipt, $is_payable, $transaction_no = "") {
        $return = '<?xml version="1.0" encoding="utf-8"?>';
        $return .= '<root>';
        $return .= '<group>';
        $return .= '<component>';
        if (strtoupper($is_transaction) == "T") {
            $getMessageTransaction = $this->getMessageTransaction($source_system, $transaction_no);
            $return .= $getMessageTransaction['message'];
        }
        if (strtoupper($is_receipt) == "T") {
            $getMessageReceipt = $this->getMessageReceipt($source_system, $transaction_no);
            $return .= $getMessageReceipt['message'];
        }
        if (strtoupper($is_payable) == "T") {
            $getMessagePayable = $this->getMessagePayable($source_system, $transaction_no);
            $return .= $getMessagePayable['message'];
        }
        $return .= '</component>';
        $return .= '</group>';
        $return .= '</root>';
        return $return;
    }

    function getMessageOld($in_param) {
        $return = '<?xml version="1.0" encoding="utf-8"?>';
        $return .= '<root>';
        $SQL = "SELECT TRX_NUMBER, STATUS_NOTA, STATUS_ARMSG 
                FROM " . $this->tableXpi2StrArInvoiceHdr . " 
                WHERE STATUS_ARMSG IS NOT NULL 
                      AND FLAG_STATUS = 'N'";
        $Query = $this->conn->query($SQL);
        if ($Query->size() > 0) {
            $return .= '<group>';
            while ($Query->next()) {
                $return .= '<component>';

                $TRX_NUMBER = $Query->get("TRX_NUMBER");
                $STATUS_NOTA = $Query->get("STATUS_NOTA");
                $STATUS_ARMSG = $Query->get("STATUS_ARMSG");
                $return .= '<transaction>';
                $return .= '<transaction_number>' . $TRX_NUMBER . '</transaction_number>';
                $return .= '<status>' . $STATUS_NOTA . '</status>';
                $return .= '<message>' . $STATUS_ARMSG . '</message>';
                $return .= '</transaction>';

                $SQL = "SELECT RECEIPT_NUMBER, STATUS_RECEIPT, STATUS_RECEIPTMSG 
                        FROM " . $this->tableXpi2StrArReceipt . " 
                        WHERE RECEIPT_NUMBER = '" . $TRX_NUMBER . "'";
                $Query2 = $this->conn->query($SQL);
                if ($Query2->size() > 0) {
                    while ($Query2->next()) {
                        $RECEIPT_NUMBER = $Query2->get("RECEIPT_NUMBER");
                        $STATUS_RECEIPT = $Query2->get("STATUS_RECEIPT");
                        $STATUS_RECEIPTMSG = $Query2->get("STATUS_RECEIPTMSG");
                        $return .= '<receipt>';
                        $return .= '<receipt_number>' . $RECEIPT_NUMBER . '</receipt_number>';
                        $return .= '<status>' . $STATUS_RECEIPT . '</status>';
                        $return .= '<message>' . $STATUS_RECEIPTMSG . '</message>';
                        $return .= '</receipt>';
                    }
                }

                $SQL = "SELECT TRX_NUMBER, STATUS, ERROR_MESSAGE 
                        FROM " . $this->tableXpi2StgApSharingStg . " 
                        WHERE TRX_NUMBER = '" . $TRX_NUMBER . "'";
                $Query2 = $this->conn->query($SQL);
                if ($Query2->size() > 0) {
                    while ($Query2->next()) {
                        $TRX_NUMBER = $Query2->get("TRX_NUMBER");
                        $STATUS = $Query2->get("STATUS");
                        $ERROR_MESSAGE = $Query2->get("ERROR_MESSAGE");
                        $return .= '<payable>';
                        $return .= '<transaction_number>' . $TRX_NUMBER . '</transaction_number>';
                        $return .= '<status>' . $STATUS . '</status>';
                        $return .= '<message>' . $ERROR_MESSAGE . '</message>';
                        $return .= '</payable>';
                    }
                }

                $return .= '</component>';

                $SQL = "UPDATE " . $this->tableXpi2StrArInvoiceHdr . " SET FLAG_STATUS = 'Y' WHERE TRX_NUMBER = '" . $TRX_NUMBER . "'";
                $Execute = $this->conn->execute($SQL);
                if (!$Execute) {
                    $this->conn->rollback();
                    $return = '<?xml version="1.0" encoding="utf-8"?>';
                    $return .= '<root>';
                    $return .= '</root>';
                    return $return;
                }
            }
            $return .= '</group>';
            $this->conn->commit();
        }
        $return .= '</root>';
        return $return;
    }

    function saveIntegrasi($in_param) {
        $xml_data = xml2ary($in_param);
        $return = '<?xml version="1.0" encoding="utf-8"?>';
        $return .= '<root>';
        if (count($xml_data) > 0) {
            $xml_data = $xml_data['root']['_c'];
            $root = $xml_data['group']['_c'];
            $countComponent = 0;
            $countComponent = count($root['component']);
            if ($countComponent > 1) {
                $return .= '<group>';
                for ($c = 0; $c < $countComponent; $c++) {
                    $return .= '<component>';
                    $component = $root['component'][$c]['_c'];
                    $transaction = $component['transaction']['_c'];
                    $header = $transaction['header']['_c'];
                    $is_transaction = trim($header['is_transaction']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_transaction']['_v'])) . "";
                    $is_receipt = trim($header['is_receipt']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_receipt']['_v'])) . "";
                    $is_payable = trim($header['is_payable']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_payable']['_v'])) . "";
                    $is_payable_resend = trim($header['is_payable_resend']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_payable_resend']['_v'])) . "";
                    if (strtoupper($is_transaction) == "T") {
                        $return .= $this->saveTransaction($transaction);
                    }
                    $receipt = $component['receipt']['_c'];
                    if (strtoupper($is_receipt) == "T") {
                        $return .= $this->saveReceipt($receipt, $transaction);
                    }
                    $payable = $component['payable']['_c'];
                    if (strtoupper($is_payable) == "T") {
                        $return .= $this->savePayable($payable, $is_payable_resend);
                    }
                    $return .= '</component>';
                }
                $return .= '</group>';
                $configuration = $xml_data['configuration']['_c'];
                $saveLog = $this->saveLog($configuration);
                $return .= $saveLog['message'];
            } elseif ($countComponent == 1) {
                $return .= '<group>';
                $return .= '<component>';
                $component = $root['component']['_c'];
                $transaction = $component['transaction']['_c'];
                $header = $transaction['header']['_c'];
                $is_transaction = trim($header['is_transaction']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_transaction']['_v'])) . "";
                $is_receipt = trim($header['is_receipt']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_receipt']['_v'])) . "";
                $is_payable = trim($header['is_payable']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_payable']['_v'])) . "";
                $is_payable_resend = trim($header['is_payable_resend']['_v']) == "" ? "" : "" . strtoupper(trim($header['is_payable_resend']['_v'])) . "";
                if (strtoupper($is_transaction) == "T") {
                    $return .= $this->saveTransaction($transaction);
                }
                $receipt = $component['receipt']['_c'];
                if (strtoupper($is_receipt) == "T") {
                    $return .= $this->saveReceipt($receipt, $transaction);
                }
                $payable = $component['payable']['_c'];
                if (strtoupper($is_payable) == "T") {
                    $return .= $this->savePayable($payable, $is_payable_resend);
                }
                $return .= '</component></group>';
                $configuration = $xml_data['configuration']['_c'];
                $saveLog = $this->saveLog($configuration);
                $return .= $saveLog['message'];
            } else {
                $return .= '<res>Format fStream SALAH1!!!</res>';
            }
        } else {
            $return .= '<res>Format fStream SALAH2!!!</res>';
        }
        $return .= '</root>';
        return $return;
    }

    function messageSaveTransaction($status = "", $message = "", $transaction_number = "") {
        $return = '<transaction>';
        $return .= '<transaction_number>' . $transaction_number . '</transaction_number>';
        $return .= '<status>' . $status . '</status>';
        $return .= '<message>' . $message . '</message>';
        $return .= '</transaction>';
        return $return;
    }

    function messageSaveReceipt($status = "", $message = "", $receipt_number = "") {
        $return = '<receipt>';
        $return .= '<receipt_number>' . $receipt_number . '</receipt_number>';
        $return .= '<status>' . $status . '</status>';
        $return .= '<message>' . $message . '</message>';
        $return .= '</receipt>';
        return $return;
    }

    function messageSavePayable($status = "", $message = "", $transaction_number = "") {
        $return = '<payable>';
        $return .= '<transaction_number>' . $transaction_number . '</transaction_number>';
        $return .= '<status>' . $status . '</status>';
        $return .= '<message>' . $message . '</message>';
        $return .= '</payable>';
        return $return;
    }

    function saveTransaction($transaction) {
        $header = $transaction['header']['_c'];
        $transaction_number = trim($header['transaction_number']['_v']) == "" ? "" : "" . strtoupper(trim($header['transaction_number']['_v'])) . "";
        $deleteInvoice = $this->deleteInvoice($transaction_number);
        if (!$deleteInvoice['status']) {
            $this->conn->rollback();
            if ($deleteInvoice['message'] == "Transaction already success") {
                $return = $this->messageSaveTransaction('Y', $deleteInvoice['message'], $transaction_number);
            } else {
                $return = $this->messageSaveTransaction('F', $deleteInvoice['message'], $transaction_number);
            }
        } else {
            $invoiceHeader = $this->insertInvoiceHeader($transaction);
            if ($invoiceHeader['status']) {
                $invoiceDetail = $this->insertInvoiceDtl($transaction, $transaction_number);
                if ($invoiceDetail['status']) {
                    $this->conn->commit();
                    $return = $this->messageSaveTransaction('Y', $invoiceDetail['message'], $transaction_number);
                } else {
                    $this->conn->rollback();
                    $return = $this->messageSaveTransaction('F', $invoiceDetail['message'], $transaction_number);
                }
            } else {
                $this->conn->rollback();
                $return = $this->messageSaveTransaction('F', $invoiceHeader['message'], $transaction_number);
            }
        }
        return $return;
    }

    function insertInvoiceDtl($transaction, $transaction_number) {
        $details = $transaction['details']['_c'];
        $countitem = 0;
        $countitem = count($details['item']);
        if ($countitem > 1) {
            for ($i = 0; $i < $countitem; $i++) {
                $item = $details['item'][$i]['_c'];
                $line_number = trim($item['line_number']['_v']) == "" ? "" : "" . strtoupper(trim($item['line_number']['_v'])) . "";
                $item_code = trim($item['item_code']['_v']) == "" ? "" : "" . strtoupper(trim($item['item_code']['_v'])) . "";
                $item_name = trim($item['item_name']['_v']) == "" ? "" : "" . strtoupper(trim($item['item_name']['_v'])) . "";
                $service_type = trim($item['service_type']['_v']) == "" ? "" : "" . strtoupper(trim($item['service_type']['_v'])) . "";
                $qty = trim($item['qty']['_v']) == "" ? "" : "" . strtoupper(trim($item['qty']['_v'])) . "";
                $unit = trim($item['unit']['_v']) == "" ? "" : "" . strtoupper(trim($item['unit']['_v'])) . "";
                $tariff = trim($item['tariff']['_v']) == "" ? "" : "" . strtoupper(trim($item['tariff']['_v'])) . "";
                $amount = trim($item['amount']['_v']) == "" ? "" : "" . strtoupper(trim($item['amount']['_v'])) . "";
                $tax_flag = trim($item['tax_flag']['_v']) == "" ? "" : "" . strtoupper(trim($item['tax_flag']['_v'])) . "";
                $tax = trim($item['tax']['_v']) == "" ? "" : "" . strtoupper(trim($item['tax']['_v'])) . "";

                $SQL = "INSERT INTO " . $this->tableXpi2StrArInvoiceDtl . "(TRX_NUMBER, LINE_NUMBER, ITEM_CODE, ITEM_NAME, SERVICE_TYPE, QTY, UNIT, TARIFF, AMOUNT, 
                        TAX_FLAG,  TAX) 
                        VALUES('" . $transaction_number . "','" . $line_number . "','" . $item_code . "','" . $item_name . "','" . $service_type . "','" . $qty . "',
                                '" . $unit . "','" . $tariff . "','" . $amount . "','" . $tax_flag . "','" . $tax . "')";
                $Execute = $this->conn->execute($SQL);
                if ($Execute) {
                    $return['status'] = true;
                    $return['message'] = 'Success';
                } else {
                    $return['status'] = false;
                    $return['message'] = 'Failed to insert transaction detail';
                    return $return;
                }
            }
        } elseif ($countitem == 1) {
            $item = $details['item']['_c'];
            $line_number = trim($item['line_number']['_v']) == "" ? "" : "" . strtoupper(trim($item['line_number']['_v'])) . "";
            $item_code = trim($item['item_code']['_v']) == "" ? "" : "" . strtoupper(trim($item['item_code']['_v'])) . "";
            $item_name = trim($item['item_name']['_v']) == "" ? "" : "" . strtoupper(trim($item['item_name']['_v'])) . "";
            $service_type = trim($item['service_type']['_v']) == "" ? "" : "" . strtoupper(trim($item['service_type']['_v'])) . "";
            $qty = trim($item['qty']['_v']) == "" ? "" : "" . strtoupper(trim($item['qty']['_v'])) . "";
            $unit = trim($item['unit']['_v']) == "" ? "" : "" . strtoupper(trim($item['unit']['_v'])) . "";
            $tariff = trim($item['tariff']['_v']) == "" ? "" : "" . strtoupper(trim($item['tariff']['_v'])) . "";
            $amount = trim($item['amount']['_v']) == "" ? "" : "" . strtoupper(trim($item['amount']['_v'])) . "";
            $tax_flag = trim($item['tax_flag']['_v']) == "" ? "" : "" . strtoupper(trim($item['tax_flag']['_v'])) . "";
            $tax = trim($item['tax']['_v']) == "" ? "" : "" . strtoupper(trim($item['tax']['_v'])) . "";
            $SQL = "INSERT INTO " . $this->tableXpi2StrArInvoiceDtl . "(TRX_NUMBER, LINE_NUMBER, ITEM_CODE, ITEM_NAME, SERVICE_TYPE, QTY, UNIT, TARIFF, AMOUNT, TAX_FLAG,  TAX) 
                    VALUES('" . $transaction_number . "','" . $line_number . "','" . $item_code . "','" . $item_name . "',
                    '" . $service_type . "','" . $qty . "','" . $unit . "','" . $tariff . "','" . $amount . "','" . $tax_flag . "','" . $tax . "')";
            $Execute = $this->conn->execute($SQL);
            if ($Execute) {
                $return['status'] = true;
                $return['message'] = 'Success';
            } else {
                $return['status'] = false;
                $return['message'] = 'Failed to insert transaction detail';
            }
        } else {
            $return['status'] = false;
            $return['message'] = 'Failed to insert transaction detail';
        }
        return $return;
    }

    function insertInvoiceHeader($transaction) {
        $header = $transaction['header']['_c'];
        $transaction_number = trim($header['transaction_number']['_v']) == "" ? "" : "" . strtoupper(trim($header['transaction_number']['_v'])) . "";
        $prevtransaction_number = trim($header['prev_transaction_number']['_v']) == "" ? "" : "" . strtoupper(trim($header['prev_transaction_number']['_v'])) . "";
        $request_number = trim($header['request_number']['_v']) == "" ? "" : "" . strtoupper(trim($header['request_number']['_v'])) . "";
        $tax_number = trim($header['tax_number']['_v']) == "" ? "" : "" . strtoupper(trim($header['tax_number']['_v'])) . "";
        $header_context = trim($header['header_context']['_v']) == "" ? "" : "" . strtoupper(trim($header['header_context']['_v'])) . "";
        $header_sub_context = trim($header['header_sub_context']['_v']) == "" ? "" : "" . strtoupper(trim($header['header_sub_context']['_v'])) . "";
        $organization_id = trim($header['organization_id']['_v']) == "" ? "" : "" . strtoupper(trim($header['organization_id']['_v'])) . "";
        $transaction_date = trim($header['transaction_date']['_v']) == "" ? "" : "" . strtoupper(trim($header['transaction_date']['_v'])) . "";
        $transaction_type = trim($header['transaction_type']['_v']) == "" ? "" : "" . strtoupper(trim($header['transaction_type']['_v'])) . "";
        $customer_number = trim($header['customer_number']['_v']) == "" ? "" : "" . strtoupper(trim($header['customer_number']['_v'])) . "";
        $customer_name = trim($header['customer_name']['_v']) == "" ? "" : "" . strtoupper(trim($header['customer_name']['_v'])) . "";
        $no_do = trim($header['no_do']['_v']) == "" ? "" : "" . strtoupper(trim($header['no_do']['_v'])) . "";
        $no_bl = trim($header['no_bl']['_v']) == "" ? "" : "" . strtoupper(trim($header['no_bl']['_v'])) . "";
        $vessel_name = trim($header['vessel_name']['_v']) == "" ? "" : "" . strtoupper(trim($header['vessel_name']['_v'])) . "";
        $arrival_date = trim($header['arrival_date']['_v']) == "" ? "" : "" . strtoupper(trim($header['arrival_date']['_v'])) . "";
        $location_code = trim($header['location_code']['_v']) == "" ? "" : "" . strtoupper(trim($header['location_code']['_v'])) . "";
        $location = trim($header['location']['_v']) == "" ? "" : "" . strtoupper(trim($header['location']['_v'])) . "";
        $delivery_date = trim($header['delivery_date']['_v']) == "" ? "" : "" . strtoupper(trim($header['delivery_date']['_v'])) . "";
        $currency = trim($header['currency']['_v']) == "" ? "" : "" . strtoupper(trim($header['currency']['_v'])) . "";
        $currency_type = trim($header['currency_type']['_v']) == "" ? "" : "" . strtoupper(trim($header['currency_type']['_v'])) . "";
        $currency_rate = trim($header['currency_rate']['_v']) == "" ? "" : "" . strtoupper(trim($header['currency_rate']['_v'])) . "";
        $currency_date = trim($header['currency_date']['_v']) == "" ? "" : "" . strtoupper(trim($header['currency_date']['_v'])) . "";
        $before_tax = trim($header['before_tax']['_v']) == "" ? "" : "" . strtoupper(trim($header['before_tax']['_v'])) . "";
        $tax = trim($header['tax']['_v']) == "" ? "" : "" . strtoupper(trim($header['tax']['_v'])) . "";
        $total = trim($header['total']['_v']) == "" ? "" : "" . strtoupper(trim($header['total']['_v'])) . "";
        $source_system = trim($header['source_system']['_v']) == "" ? "" : "" . strtoupper(trim($header['source_system']['_v'])) . "";
        $operation_unit_code = trim($header['operation_unit_code']['_v']) == "" ? "" : "" . strtoupper(trim($header['operation_unit_code']['_v'])) . "";
        $atribute2 = trim($header['atribute2']['_v']) == "" ? "" : "" . strtoupper(trim($header['atribute2']['_v'])) . "";
        $atribute3 = trim($header['atribute3']['_v']) == "" ? "" : "" . htmlspecialchars(strtoupper(trim($header['atribute3']['_v'])), ENT_QUOTES) . "";
        $atribute5 = trim($header['atribute5']['_v']) == "" ? "" : "" . htmlspecialchars(strtoupper(trim($header['atribute5']['_v'])), ENT_QUOTES) . "";


        $SQL = "SELECT TRX_NUMBER FROM " . $this->tableXpi2StrArInvoiceHdr . " 
                WHERE TRX_NUMBER = '" . $transaction_number . "'";
        $Query = $this->conn->query($SQL);
        if ($Query->size == 0) {
            $SQL = "INSERT INTO " . $this->tableXpi2StrArInvoiceHdr . "(TRX_NUMBER, PREV_TRX_NUMBER, REQ_NUMBER, HEADER_CONTEXT, 			HEADER_SUB_CONTEXT, ORG_ID, TRX_DATE, TRX_TYPE, CUSTOMER_NUMBER,
                                                                        CUSTOMER_NAME, NO_DO, NO_BL, VESSEL_NAME, ARRIVAL_DATE, LOCATION, DELIVERY_DATE, CURRENCY, CURRENCY_TYPE, CURRENCY_RATE, CURRENCY_DATE, DPP, 
                                                                        TAX, TOTAL, SOURCE_SYSTEM, OPERATING_UNIT_CODE, ATTRIBUTE2, ATTRIBUTE3, ATTRIBUTE5) 
                    VALUES('" . $transaction_number . "','" . $prevtransaction_number . "','" . $request_number . "','" . $header_context . "','" . $header_sub_context . "','" . $organization_id . "',
                            TO_DATE('" . $transaction_date . "', 'DD/MM/YYYY HH24:MI:SS'),'" . $transaction_type . "','" . $customer_number . "','" . $customer_name . "','" . $no_do . "','" . $no_bl . "',
                            '" . $vessel_name . "',TO_DATE('" . $arrival_date . "', 'DD/MM/YYYY'),'" . $location . "',TO_DATE('" . $delivery_date . "', 'DD/MM/YYYY'),'" . $currency . "','" . $currency_type . "',
                            '" . $currency_rate . "','" . $currency_date . "','" . $before_tax . "','" . $tax . "','" . $total . "', '" . $source_system . "', '" . $operation_unit_code . "', 
                            '" . $atribute2 . "', '" . $atribute3 . "', '" . $atribute5 . "')";
            $Execute = $this->conn->execute($SQL);
            if ($Execute) {
                $return['status'] = true;
                $return['message'] = 'Success';
            } else {
                $return['status'] = false;
                $return['message'] = 'Failed to insert transaction header';
            }
        } else {
            $return['status'] = false;
            $return['message'] = 'Transaction already exist';
        }
        return $return;
    }

    function deleteInvoice($transaction_number) {
        $SQL = "SELECT STATUS_NOTA 
                FROM " . $this->tableXpi2StrArInvoiceHdr . " 
                WHERE TRX_NUMBER = '" . $transaction_number . "'";
        $Query = $this->conn->query($SQL);
        $Query->next();
        $STATUS_NOTA = $Query->get("STATUS_NOTA");
        if ($STATUS_NOTA != "S") {
            $SQL = "DELETE FROM " . $this->tableXpi2StrArInvoiceDtl . " WHERE TRX_NUMBER = '" . $transaction_number . "'";
            $Execute = $this->conn->execute($SQL);
            if ($Execute) {
                $SQL = "DELETE FROM " . $this->tableXpi2StrArInvoiceHdr . " WHERE TRX_NUMBER = '" . $transaction_number . "'";
                $Execute = $this->conn->execute($SQL);
                if ($Execute) {
                    $return['status'] = true;
                    $return['message'] = 'Success';
                } else {
                    $return['status'] = false;
                    $return['message'] = 'Failed to delete invoice';
                }
            } else {
                $return['status'] = false;
                $return['message'] = 'Failed to delete invoice';
            }
        } else {
            $return['status'] = false;
            $return['message'] = 'Transaction already success';
        }
        return $return;
    }

    function saveReceipt($receipt, $transaction) {
        $receipt_number = trim($receipt['receipt_number']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['receipt_number']['_v'])) . "";
        $deleteReceipt = $this->deleteReceipt($receipt_number);
        if (!$deleteReceipt['status']) {
            $this->conn->rollback();
            $return = $this->messageSaveReceipt('F', $deleteReceipt['message'], $receipt_number);
        } else {
            $insertReceipt = $this->insertReceipt($receipt, $transaction);
            if ($insertReceipt['status']) {
                $this->conn->commit();
                $return = $this->messageSaveReceipt('Y', $insertReceipt['message'], $receipt_number);
            } else {
                $this->conn->rollback();
                $return = $this->messageSaveReceipt('F', $insertReceipt['message'], $receipt_number);
            }
        }
        return $return;
    }

    function insertReceipt($receipt, $transaction) {
        $receipt_number = trim($receipt['receipt_number']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['receipt_number']['_v'])) . "";
        $receipt_method = trim($receipt['receipt_method']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['receipt_method']['_v'])) . "";
        $receipt_account = trim($receipt['receipt_account']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['receipt_account']['_v'])) . "";
        $organization_id = trim($receipt['organization_id']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['organization_id']['_v'])) . "";
        $bank_id = trim($receipt['bank_id']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['bank_id']['_v'])) . "";
        $customer_number = trim($receipt['customer_number']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['customer_number']['_v'])) . "";
        $customer_name = trim($receipt['customer_name']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['customer_name']['_v'])) . "";
        $receipt_date = trim($receipt['receipt_date']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['receipt_date']['_v'])) . "";
        $currency = trim($receipt['currency']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['currency']['_v'])) . "";
        $currency_type = trim($receipt['currency_type']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['currency_type']['_v'])) . "";
        $currency_rate = trim($receipt['currency_rate']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['currency_rate']['_v'])) . "";
        $currency_date = trim($receipt['currency_date']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['currency_date']['_v'])) . "";
        $amount = trim($receipt['amount']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['amount']['_v'])) . "";
        $receipt_type = trim($receipt['receipt_type']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['receipt_type']['_v'])) . "";
        $receipt_sub_type = trim($receipt['receipt_sub_type']['_v']) == "" ? "" : "" . strtoupper(trim($receipt['receipt_sub_type']['_v'])) . "";

        $header = $transaction['header']['_c'];
        $source_system = trim($header['source_system']['_v']) == "" ? "" : "" . strtoupper(trim($header['source_system']['_v'])) . "";


        $SQL = "INSERT INTO " . $this->tableXpi2StrArReceipt . "(RECEIPT_NUMBER, RECEIPT_METHOD, RECEIPT_ACCOUNT, ORG_ID, BANK_ID, CUSTOMER_NUMBER, RECEIPT_DATE, 
                                                                 TRX_DATE, CURRENCY, CURRENCY_TYPE, CURRENCY_RATE, CURRENCY_DATE, AMOUNT, RECEIPT_TYPE, RECEIPT_SUB_TYPE, CUSTOMER_NAME, REF_NUMBER, SOURCE_SYSTEM) 
                VALUES('" . $receipt_number . "','" . $receipt_method . "','" . $receipt_account . "','" . $organization_id . "', '" . $bank_id . "',
                        '" . $customer_number . "',TO_DATE('" . $receipt_date . "', 'DD/MM/YYYY HH24:MI:SS'),TO_DATE('" . $receipt_date . "', 'DD/MM/YYYY HH24:MI:SS'),'" . $currency . "','" . $currency_type . "','" . $currency_rate . "',
                        '" . $currency_date . "','" . $amount . "','" . $receipt_type . "','" . $receipt_sub_type . "','" . $customer_name . "','" . $receipt_number . "', '" . $source_system . "')";
        $Execute = $this->conn->execute($SQL);
        if ($Execute) {
            $return['status'] = true;
            $return['message'] = 'Success';
        } else {
            $return['status'] = false;
            $return['message'] = 'Failed to insert receipt';
        }
        return $return;
    }

    function deleteReceipt($receipt_number) {
        $SQL = "SELECT STATUS_RECEIPT 
                FROM " . $this->tableXpi2StrArReceipt . " 
                WHERE RECEIPT_NUMBER = '" . $receipt_number . "'";
        $Query = $this->conn->query($SQL);
        $Query->next();
        $STATUS_RECEIPT = $Query->get("STATUS_RECEIPT");
        if ($STATUS_RECEIPT != "S") {
            $SQL = "DELETE FROM " . $this->tableXpi2StrArReceipt . " WHERE RECEIPT_NUMBER = '" . $receipt_number . "'";
            $Execute = $this->conn->execute($SQL);
            if ($Execute) {
                $return['status'] = true;
                $return['message'] = 'Success';
            } else {
                $return['status'] = false;
                $return['message'] = 'Failed to delete receipt';
            }
        } else {
            $return['status'] = false;
            $return['message'] = 'Receipt already success';
        }
        return $return;
    }

    function savePayable($payable, $is_payable_resend) {
        $transaction_number = trim($payable['transaction_number']['_v']) == "" ? "" : "" . strtoupper(trim($payable['transaction_number']['_v'])) . "";
        $organization_id = trim($payable['organization_id']['_v']) == "" ? "" : "" . strtoupper(trim($payable['organization_id']['_v'])) . "";
        $deletePayable = $this->deletePayable($transaction_number);
        if (!$deletePayable['status']) {
            $this->conn->rollback();
            $return = $this->messageSavePayable('F', $deletePayable['message'], $transaction_number);
            return $return;
        }
        $insertPayableStgAP = $this->insertPayableStgAP($payable);
        if ($insertPayableStgAP['status']) {
            if (strtoupper($is_payable_resend) == "T") {
                $populateSharing = $this->generatePopulateSharing($organization_id, $transaction_number);
                if ($populateSharing['status']) {
                    $this->conn->commit();
                    $return = $this->messageSavePayable('Y', $populateSharing['message'], $transaction_number);
                } else {
                    $this->conn->rollback();
                    $return = $this->messageSavePayable('F', $populateSharing['message'], $transaction_number);
                }
            } else {
                $this->conn->commit();
                $return = $this->messageSavePayable('Y', $insertPayableStgAP['message'], $transaction_number);
            }
        } else {
            $this->conn->rollback();
            $return = $this->messageSavePayable('F', $insertPayableStgAP['message'], $transaction_number);
        }
        return $return;
    }

    function generatePopulateSharing($organization_id, $transaction_number) {
        $SQL = "BEGIN " . $this->tableXpi2ApSharingPkg . "(:in_org_id, :in_trx_number, :out_status, :out_message); END;";
        $bindParam = array(
            "in_org_id" => $organization_id,
            "in_trx_number" => $transaction_number,
            "out_status" => "",
            "out_message" => "",
        );
        $Execute = $this->conn->executeProcedure($SQL, $bindParam);
        if ($Execute) {
            $SQL = "UPDATE " . $this->tableXpi2StgAp . "
                    SET STATUS = '" . $bindParam["out_status"] . "', ERROR_MESSAGE = '" . $bindParam["out_message"] . "', 
                    WHERE TRX_NUMBER = '" . $transaction_number . "'";
            $Execute = $this->conn->execute($SQL);
            if ($Execute) {
                $return['status'] = true;
                $return['message'] = 'Success';
            } else {
                $return['status'] = false;
                $return['message'] = 'Failed to update sharing';
            }
        } else {
            $return['status'] = false;
            $return['message'] = 'Failed to generate populate sharing';
        }
        return $return;
    }

    function generatePopulateSharingOld($organization_id, $transaction_number) {
        $SQL = "BEGIN " . $this->tableXpi2ApSharingPkg . "('" . $organization_id . "', '" . $transaction_number . "', '', ''); END;";
        $Execute = $this->conn->execute($SQL);
        if ($Execute) {
            $return['status'] = true;
            $return['message'] = 'Success';
        } else {
            $return['status'] = false;
            $return['message'] = 'Failed to generate populate sharing';
        }
        return $return;
    }

    function insertPayableStgAP($payable) {
        $transaction_number = trim($payable['transaction_number']['_v']) == "" ? "" : "" . strtoupper(trim($payable['transaction_number']['_v'])) . "";
        $organization_id = trim($payable['organization_id']['_v']) == "" ? "" : "" . strtoupper(trim($payable['organization_id']['_v'])) . "";
        $branch_code = trim($payable['branch_code']['_v']) == "" ? "" : "" . strtoupper(trim($payable['branch_code']['_v'])) . "";
        $module_code = trim($payable['module_code']['_v']) == "" ? "" : "" . strtoupper(trim($payable['module_code']['_v'])) . "";
        $supplier_number = trim($payable['customer_number']['_v']) == "" ? "" : "" . strtoupper(trim($payable['customer_number']['_v'])) . "";
        $supplier_name = trim($payable['customer_name']['_v']) == "" ? "" : "" . strtoupper(trim($payable['customer_name']['_v'])) . "";
        $currency = trim($payable['currency']['_v']) == "" ? "" : "" . strtoupper(trim($payable['currency']['_v'])) . "";
        $currency_type = trim($payable['currency_type']['_v']) == "" ? "" : "" . strtoupper(trim($payable['currency_type']['_v'])) . "";
        $currency_rate = trim($payable['currency_rate']['_v']) == "" ? "" : "" . strtoupper(trim($payable['currency_rate']['_v'])) . "";
        $currency_date = trim($payable['currency_date']['_v']) == "" ? "" : "" . strtoupper(trim($payable['currency_date']['_v'])) . "";
        $amount = trim($payable['amount']['_v']) == "" ? "" : "" . strtoupper(trim($payable['amount']['_v'])) . "";
        $share_percentage = trim($payable['share_percentage']['_v']) == "" ? "" : "" . strtoupper(trim($payable['share_percentage']['_v'])) . "";

        $SQL = "INSERT INTO " . $this->tableXpi2StgAp . "(BRANCH_CODE, MODULE_CODE, TRX_NUMBER, ORG_ID, CUSTOMER_NUMBER, CUSTOMER_NAME, AMOUNT, CURRENCY, CURRENCY_TYPE, 
                CURRENCY_RATE, CURRENCY_DATE, SHARE_PERCENTAGE) 
                VALUES('" . $branch_code . "','" . $module_code . "','" . $transaction_number . "','" . $organization_id . "', '" . $supplier_number . "','" . $supplier_name . "','" . $amount . "','" . $currency . "','" . $currency_type . "',
                '" . $currency_rate . "','" . $currency_date . "','" . $share_percentage . "')";
        $Execute = $this->conn->execute($SQL);
        if ($Execute) {
            $return['status'] = true;
            $return['message'] = 'Success';
        } else {
            $return['status'] = false;
            $return['message'] = 'Failed to insert payable';
        }
        return $return;
    }

    function deletePayable($transaction_number) {
        $SQL = "SELECT STATUS
                FROM " . $this->tableXpi2StgAp . " 
                WHERE TRX_NUMBER = '" . $transaction_number . "'";
        $Query = $this->conn->query($SQL);
        $Query->next();
        $STATUS = $Query->get("STATUS");
        if (($STATUS != "S") && ($STATUS != "I")) {
            $SQL = "DELETE FROM " . $this->tableXpi2StgAp . " WHERE TRX_NUMBER = '" . $transaction_number . "'";
            $Execute = $this->conn->execute($SQL);
            if ($Execute) {
                $SQL = "DELETE FROM " . $this->tableXpi2StgApSharingStg . " WHERE TRX_NUMBER = '" . $transaction_number . "'";
                $Execute = $this->conn->execute($SQL);
                if ($Execute) {
                    $return['status'] = true;
                    $return['message'] = 'Success';
                } else {
                    $return['status'] = false;
                    $return['message'] = 'Failed to delete payable sharing';
                }
            } else {
                $return['status'] = false;
                $return['message'] = 'Failed to delete payable';
            }
        } else {
            $return['status'] = false;
            $return['message'] = 'payable already success';
        }
        return $return;
    }

    function messageLog($source_apps = "", $ip = "", $request_date = "") {
        $return = '<configuration>';
        $return .= '<source_apps>' . $source_apps . '</source_apps>';
        $return .= '<ip_address>' . $ip . '</ip_address>';
        $return .= '<webservice_request_date>' . $request_date . '</webservice_request_date>';
        $return .= '<webservice_response_date>' . date('d-m-Y H:i:s') . '</webservice_response_date>';
        $return .= '<token></token>';
        $return .= '<key></key>';
        $return .= '</configuration>';
        return $return;
    }

    function saveLog($log) {
        $ip_address = trim($log['ip_address']['_v']) == "" ? "" : "" . strtoupper(trim($log['ip_address']['_v'])) . "";
        $request_date = trim($log['webservice_request_date']['_v']) == "" ? "" : "" . strtoupper(trim($log['webservice_request_date']['_v'])) . "";
        $source_apps = trim($log['source_apps']['_v']) == "" ? "" : "" . strtoupper(trim($log['source_apps']['_v'])) . "";
        $ip = $this->get_ip_address();
        $SQL = "INSERT INTO " . $this->tableXpi2IntegrasiLog . " (IP_LOG, IP_REQUEST, SOURCE_APPS, WS_REQ_DATE, WS_RES_DATE) 
                VALUES ( '" . $ip . "', '" . $ip_address . "','" . $source_apps . "',TO_DATE('" . $request_date . "', 'DD/MM/YYYY HH24:MI:SS'),SYSDATE )";
        $Execute = $this->conn->execute($SQL);
        if ($Execute) {
            $this->conn->commit();
            $return['status'] = true;
            $return['message'] = $this->messageLog($source_apps, $ip, $request_date);
        } else {
            $this->conn->rollback();
            $return['status'] = false;
            $return['message'] = $this->messageLog();
        }
        return $return;
    }

    function get_ip_address() {
        // check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // check for IPs passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple ips exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (validate_ip($ip))
                        return $ip;
                }
            } else {
                if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];

        // return unreliable ip since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }

}

?>