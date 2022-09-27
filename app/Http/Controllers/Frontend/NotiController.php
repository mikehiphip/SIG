<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontendController;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

####### Include
use Auth;
use DB;
use Session;
use Cookie;
use General;
use Socialite;

class NotiController extends FrontendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function notiEmail($sData)
    {  
		// return "Test1";
        $sMember 	= \App\Models\ReceiveEmail::where('isActive', 'Y')->get();
        // dd($sMember);
        $email_to 	= "";
        foreach($sMember as $k => $v){
            if($k==0){
                $email_to .= $v->email;
            }else{
                $email_to .= ', '.$v->email;
            }
        }

        $this->contact_sendmail($email_to, $sData);
        // $this->contact_sendmail($email_to);
        
        // dd('test');
        return redirect('');
    }

    public function contact_sendmailv_html_header()
    {
        /* /public/backend/images */
        $detail	= '
        <html>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="white" align="center">
                <tr>
                    <td	style="width:100%; text-align:center">
                        <img src="'.url('').'/backend/images/sig2.png" / style="width:20%;">
                    </td>
                </tr>
            </table>';
        return $detail;
                        
    }

    public function contact_sendmailv_html_center($sData)
    {		
        // $train = DB::table('sg_train_emp')->where('id_train',$sData->id)->get();
        // $detail = "";
        // $detail.="Please see the training record as table below.";


        
        // $detail.= '
        //     <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="white" align="center">
        //         <thead>
        //             <tr>
        //                 <th>Employee ID <br />หมายเลขพนักงาน</th>
        //                 <th>Name <br />ชื่อพนักงาน</th>
        //                 <th>Department <br />แผนก</th>
        //                 <th>Video Duration <br />ความยาววิดิโอ</th>
        //                 <th>Training Date <br />วันที่อบรบ</th>
        //                 <th>Training Time <br />ช่วงเวลาที่อบรบ</th>
        //                 <th>Training Duration <br />ระยะเวลาในการอบรบ</th>
        //                 <th>Delta <br />เทียบกับเวลามาตราฐาน</th>
        //             </tr>
        //         </thead>
        //         <tbody>
        //         ';
        //         if($train)
        //         {
        //             foreach($train as $t)
        //             {
        //                 $video = DB::table('sg_video')->where('id',$sData->id_vi)->first();
        //                 $data = DB::table('sg_employee')->where('code',$t->id_emp)->first();
        //                 $name = "$data->prefixnamethai $data->namethai $data->lastnamethai";
        //                 $date_train = date('d/m/Y',strtotime($data->created_at));
        //                 $time_train = date('H:i',strtotime($data->created_at));
        //                 $detail.='<tr>
        //                     <td>'.$t->id_emp.'</td>
        //                     <td>'.$name.'</td>
        //                     <td>'.$data->department_name.'</td>
        //                     <td>'.$video->unit.'</td>
        //                     <td>'.$date_train.'</td>
        //                     <td>'.$time_train.' น.</td>
        //                     <td>'.$sData->vi_time_unit.'</td>
        //                     <td>'.$video->unit.'</td>
        //                 </tr>
        //                 ';
        //             }
        //         }

        //         $detail.='
        //         </tbody>
        //     </table>
        // ';


        $train = DB::table('sg_train_emp')->where('id_train',$sData->id)->get();
        $detail = "";
        $detail.="Please see the training record as table below.";

        $tran_list = DB::table('sg_train_list')->where('sg_train_id',$sData->id)->get();
        if($tran_list)
        {
            foreach($tran_list as $tl)
            {
                $detail.='
                <p><b>การอบรมหัวข้อ</b> : '.$tl->vi_detail.'</p>
                ';
                $detail.= '
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" bgcolor="white" align="center">
                        <thead>
                            <tr>
                                <th>Employee ID <br />หมายเลขพนักงาน</th>
                                <th>Name <br />ชื่อพนักงาน</th>
                                <th>Department <br />แผนก</th>
                                <th>Video Duration <br />ความยาววิดิโอ</th>
                                <th>Training Date & Time <br />วันที่อบรบและเวลา</th>
                                <th>Training Duration <br />ระยะเวลาในการอบรบ</th>
                                <th>Delta <br />เทียบกับเวลามาตราฐาน</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';
                        if($train)
                        {
                            foreach($train as $t)
                            {
                                $video = DB::table('sg_video')->where('id',$tl->id_vi)->first();
                                $data = DB::table('sg_employee')->where('code',$t->id_emp)->first();
                                $name = "$data->prefixnamethai $data->namethai $data->lastnamethai";
                                $date_train = date('d/m/Y',strtotime($tl->created_at));
                                $time_train = date('H:i',strtotime($tl->created_at));
                                $detail.='<tr>
                                    <td>&nbsp; '.$t->id_emp.'</td>
                                    <td>&nbsp; '.$name.'</td>
                                    <td>&nbsp; '.$data->department_name.'</td>
                                    <td>&nbsp; '.$video->unit.'</td>
                                    <td style="text-align:center;">'.$date_train.' '.$time_train.' น.</td>
                                    <td>&nbsp; '.$tl->vi_time_unit.'</td>
                                    <td>&nbsp; '.$tl->vi_stand_unit.'</td>
                                </tr>
                                ';
                            }
                        }
        
                        $detail.='
                        </tbody>
                    </table>
                ';
            }
        }
        
        return $detail;
    }

    public function contact_sendmailv_html_footer()
    {
        return $detail	= '
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="white" align="center">
                        <tr style="background-color:lightgray;line-height: 1px;">
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <center>
                                    <table width="100%" cellspacing="0" cellpadding="15" style="font-family: Sarabun, sans-serif;border: 1px solid transparent;background-color:transparent; " >
                                    <tr>
                                        <td style="width:50%;">
                                            <span style="font-size: 12px;color:gray; line-height:20px; ">
                                            <b>SIG Combibloc Ltd. (Rayong Office)</b><br>
                                            33 Moo 4, Highway No. 331 Amphur Pluakdaeng Rayong 21140, Thailand
                                            </span>
                                        </td>
                                        <td style="width:40%;  text-align:right;"><span style="font-size: 12px;color:gray; line-height:20px;">Phone +66-3895-4100 | Fax +66-3895-4105</span></td>
                                    </tr>
                                    </table>    
                                </center>
                            </td>
                        </tr>
                    </table>
                </html>';
    }

    public function contact_sendmail($email_to, $sData)
    {

        $addresses = explode(', ',$email_to);
      
        $mail = new PHPMailer(true);
        try { 	                 
            //Server settings 	
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            $mail->setFrom('noreply@top.orangeworkshop.info', 'PRA eSIGAR - Auto Report');
            foreach ($addresses as $address) {
                $mail->addAddress($address);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'PRA eSIGAR - Auto Report';
            $mail->Body    = '';
            $mail->Body .= $this->contact_sendmailv_html_header();
            $mail->Body .= $this->contact_sendmailv_html_center($sData);
            $mail->Body .= $this->contact_sendmailv_html_footer();
            
            $mail->send();
            // echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function trainSendmail(Request $request)
    {
        $this->contact_sendmail('pipat.pimnont@gmail.com');
    }
}
