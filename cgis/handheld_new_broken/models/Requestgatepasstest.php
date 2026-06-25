<?php defined('BASEPATH') or exit('No direct script access allowed');

class Requestgatepasstest extends CI_Model
{

        public function message2a($arraydata)
        {
                $url = "https://api.npct1.co.id:9443/api/v1/checkTar";
                $user = "BEHANDLE";
                $key ="5d3a2ffcb778f4b1c224f2447c048c8f";

                $e = explode('-',$arraydata->ID_FLAT);
                $tid = trim($e[1]);
                $e2 = explode('/',$arraydata->TAR);
                $tar = $e2[0];
                $nocont = $arraydata->NO_CONT;
                $weight = $arraydata->BERAT_TRUCK;

                $addXML ='<request> 
                    <tid>'.$tid.'</tid>
                    <tar>'.$tar.'</tar>
                    <cont_no>'.$nocont.'</cont_no>
                    <weight>'.$weight.'</weight>
                    <handling_type>IN</handling_type>
                    </request>
                    ';

                // $addXML= trim(str_replace(" ", "",$addXML));
                $addXML = trim((preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML))));
                // echo $addXML;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
CURLOPT_SSL_VERIFYPEER => false,
CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: '.$user,
                    'NPCT-API-Key: '.$key,
                    'Content-Type: application/xml'
                ),
                ));
                $response = curl_exec($curl);
                // if (!curl_errno($curl)) {
                //     $info = curl_getinfo($curl);
                //     echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                // }else{
                //     echo "Connection Failed =".curl_error($curl);
                // }
                curl_close($curl); 
                // print_r($response);
                $json = simplexml_load_string($response);
                $rawrespon = json_encode($response);
                $data = $this->db->query("INSERT INTO `tpk_ipc`.`log_integrasi_behandle` (`type`, `no_cont`, `raw_request`, `raw_response`) VALUES ('message2a', '$arraydata->NO_CONT', '$addXML', '$rawrespon')");
                return $json;
                
        }


        public function message2b($arraydata)
        {
                $url = "https://api.npct1.co.id:9443/api/v1/gateIn";
                $user = "BEHANDLE";
                $key ="5d3a2ffcb778f4b1c224f2447c048c8f";
                $respon='';
                $ata = $timenow = date('Y-m-d').'T'.date('00:H:i+s:00');//'2021-07-13T00:08:59+07:00';
                $plate = trim($arraydata->NO_PLAT);//'B9678WG';
                $e2 = explode('/',$arraydata->TAR);
                $tar = $e2[0];//'ASX8558';
                $e = explode('-',$arraydata->ID_FLAT);
                $tid = trim($e[1]);//'18723';
                $weight = $arraydata->BERAT_TRUCK;//'12760';
                $ContainerId = $arraydata->NO_CONT;//'UETU4044009' ;
                $ISOCode = $arraydata->ISO_CODE;//'42G0' ;
                $LoadingStatus = $arraydata->KD_CONT_JENIS;//'F' ;
                $Vessel = $arraydata->VESSEL;//'MEPIS' ;
                $Voyage = $arraydata->VOY_IN;//'029S' ;
                $ContainerCondition = 'No Damage' ;
                $ContainerHeight = '0.0' ;
                $ContainerLength = '0.0' ;
                $ContainerType = $arraydata->TIPE_CONT;//'DRY' ;
                $CustomsReference = $arraydata->NO_DOK;//'SPPB211193/KPU.01/2020|PIB210813' ;
                $GrossWeight = $arraydata->BERAT_TRUCK;//'12760';
                $WeighingTime = $timenow = date('Y-m-d').'T'.date('00:H:i+s:00');//'2021-07-13T00:08:59+07:00';
                $totalWeight = $arraydata->BERAT_TRUCK;//'12760';

                if ($arraydata->FL_DG = 'N') {
                    $DamagePresent = 'N';
                }else{
                    $DamagePresent = 'Y';
                }
                if ($arraydata->FL_OOG = 'N') {
                    $ContainerOOG = 'F';
                }else{
                    $ContainerOOG = 'T';
                }

                $addXML ='<TIDRegistration_request> 
                                <TruckEvent> 
                                <MessageHeader> 
                                    <Sender>IPC</Sender> 
                                    <Recipient>NPCT1</Recipient> 
                                    <MessageType>CIC</MessageType> 
                                    <MessageVersion>1.0.0</MessageVersion> 
                                    <MessageId>9990</MessageId> 
                                    <MessageName>CGPCHECK</MessageName> 
                                    <MessageFunction>CREATE</MessageFunction> 
                                    <Terminal>NPCT1</Terminal> 
                                    <TruckingCompany>NPCT1</TruckingCompany>
                                </MessageHeader>
                                <Status> 
                                    <StatusCode>ANC</StatusCode> 
                                </Status> 
                                <TruckCall> 
                                    <TruckingCompany>NPCT1</TruckingCompany> 
                                    <LicensePlate>'.$plate.'</LicensePlate> 
                                    <TAR>'.$tar.'</TAR> 
                                    <TID>'.$tid.'</TID> 
                                    <TruckingWeight>'.$weight.'</TruckingWeight>
                                    <ATA>'.$ata.'</ATA> 
                                    <ExpectedLane>1</ExpectedLane> 
                                </TruckCall>
                                <Prenotifications> 
                                    <Prenotification> 
                                        <Container> 
                                            <ContainerId>'.$ContainerId.'</ContainerId> 
                                            <PositionOnTruck></PositionOnTruck> 
                                            <ContainerReverse>FALSE</ContainerReverse> 
                                            <LoadingStatus>'.$LoadingStatus.'</LoadingStatus> 
                                            <GrossWeight>'.$GrossWeight.'</GrossWeight> 
                                            <WeighingTime>'.$WeighingTime.'</WeighingTime> 
                                            <TotalWeight>'.$totalWeight.'</TotalWeight> 
                                            <ISOCode>'.$ISOCode.'</ISOCode> 
                                            <SealPresent></SealPresent> 
                                            <DamagePresent>'.$DamagePresent.'</DamagePresent> 
                                            <IMDGPresent></IMDGPresent> 
                                            <ContainerOOG>'.$ContainerOOG.'</ContainerOOG> 
                                            <ContainerDam1></ContainerDam1> 
                                            <ContainerDam2></ContainerDam2> 
                                            <ContainerDam3></ContainerDam3> 
                                            <ContainerDam4></ContainerDam4> 
                                            <ContainerDam5></ContainerDam5> 
                                            <ContainerDam6></ContainerDam6> 
                                            <ContainerDam7></ContainerDam7> 
                                            <ContainerDam8></ContainerDam8> 
                                        </Container> 
                                    </Prenotification> 
                                </Prenotifications> 
                                </TruckEvent>
                            </TIDRegistration_request>';
                // $addXML= trim(str_replace(" ", "",$addXML));
                $addXML = trim((preg_replace('/\s\s+/', '', str_replace("\n", " ", $addXML))));
                // echo $addXML;die();
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
CURLOPT_SSL_VERIFYPEER => false,
CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>$addXML,
                CURLOPT_HTTPHEADER => array(
                    'User-ID: '.$user,
                    'NPCT-API-Key: '.$key,
                    'Content-Type: application/xml'
                ),
                ));
                $response = curl_exec($curl);
                // if (!curl_errno($curl)) {
                //     $info = curl_getinfo($curl);
                //     echo "Connection Success , This is Url : ", $info['url'], "\r\n";
                // }else{
                //     echo "Connection Failed =".curl_error($curl);
                // }
                curl_close($curl); 
                $json = simplexml_load_string($response);
                $rawrespon = json_encode($response);
                $data = $this->db->query("INSERT INTO `tpk_ipc`.`log_integrasi_behandle` (`type`, `no_cont`, `raw_request`, `raw_response`) VALUES ('message2b', '$arraydata->NO_CONT', '$addXML', '$rawrespon')");
                return $json;
        }
}