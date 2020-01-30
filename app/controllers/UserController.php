<?php

namespace App\Controllers;

use App\Courses;
use App\Payments;
use App\Users;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

class UserController extends controller
{
    public function profile($id)
    {
        $profile = Users::select('*')->where('id', '=', $id)->get();
        return view('user/profile', ['profile' => $profile]);
    }

    public function payments($id)
    {
        $payments = Payments::select('payments.*, courses.name AS productId')
            ->join('courses', 'courses.id', '=', 'payments.productId')
            ->where('payments.userId', '=', $id)
            ->getAll();

        $user = Users::select('*')->where('id', '=', $id)->get();

        return view('user/payments', ['user' => $user, 'payments' => $payments]);
    }

    public function paymentShow($payment_id, $profile_id)
    {
        $date = date("Y-m-d");

        $profile = Users::select('*')->where('id', '=', $profile_id)->get();

        $payments = Payments::select('payments.*, courses.name AS productId, courses.about')
            ->join('courses', 'courses.id', '=', 'payments.productId')
            ->where('payments.userId', '=', $profile_id)
            ->where('payments.id', '=', $payment_id)
            ->get();

        if(empty($payments)) {
            return view("errors/error404");
        }

        $mpdf = new Mpdf();

        $css = '
        body {font-family: sans-serif;
	    font-size: 10pt;
        }
        p {	margin: 0pt; }
        table.items {
            border: 0.1mm solid #000000;
        }
        td { vertical-align: top; }
        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }
        table thead td { background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: sans-serif;
        }
        .items {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }
        .items {
            text-align: right;
            border: 0.1mm solid #000000;
        }
        .items td.cost {
            text-align: "." center;
        }
        ';

        $html = '
        <htmlpageheader name="myheader">
            <h1 style="text-align: center">Sąskaita - faktūra</h1>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            Puslapis {PAGENO} / {nb}
            </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myfooter" value="on" />
        mpdf-->
        <br /><br />
        <div style="text-align: right"> ' . $date . '</div>
            <table width="100%" style="font-family: serif;" cellpadding="10"><tr>
                <td width="45%" style="border: 0.1mm solid #888888; "><span style="font-size: 7pt; color: #555555; font-family: sans;">Pardavėjas:</span><br /><br />UAB "CBA Anglų Kalbos Kursai"<br />154 Kęstučio g.<br />Vilnius</td>
                <td width="10%">&nbsp;</td>
                <td width="45%" style="border: 0.1mm solid #888888;"><span style="font-size: 7pt; color: #555555; font-family: sans;">Pirkėjas:</span><br /><br /> ' . $profile->name . ' ' . $profile->surname . ' <br /> ' . $profile->email . ' </td>
            </tr></table>
            <br />
            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
                <thead>
                <tr>
                <td width="10%">Mokėjimo nr.</td>
                <td width="25%">Kurso pavadinimas</td>
                <td width="40%">Apie kursą</td>
                <td width="10%">Kaina</td>
                <td width="15%">Pirkimo data</td>
                </tr>
                </thead>
                    <tbody>
                    <!-- ITEMS HERE -->
                    <tr>
                    <td align="center"> ' . $payment_id . ' </td>
                    <td align="center">' . $payments->productId . '</td>
                    <td align="center">' . $payments->about . ' </td>
                    <td class="cost">' . $payments->price . ' &#8364;</td>
                    <td class="cost">' . $payments->createdOn . '</td>
                    </tr>
                    </tbody>
            </table>

        ';

        $mpdf->SetTitle('Sąskaita');
        $mpdf->writeHtml($css, HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
        $mpdf->Output('Saskaita-Faktura', Destination::INLINE);


        return $mpdf;
    }
}
