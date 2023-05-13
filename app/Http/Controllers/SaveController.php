<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    public function createEncode(Request $request)
    {
        // Get the uploaded image file from the request
        $image = $request->file('image');
        $file = $request->file('file') ?? null;
        $text = $request->input('text') ?? null;
        // Get the message to be hidden
        $message = $file == null ? $text : $file->get();
        $message = $message . 'a27fa23e7316cb8fb7';
        $password = $request->input('password') ?? null;
        if ($password != null) {
            $message .= md5($password) . 'drtypoiytrdfvgbhjuhyg';
        }
        // Open the image with the GD library
        $img = imagecreatefrompng($image->getPathname());
        // Get the image dimensions
        $width = imagesx($img);
        $height = imagesy($img);

        // Convert the message to binary and append a null terminator
        $binMessage = '';
        for ($i = 0; $i < strlen($message); $i++) {
            $binMessage .= str_pad(decbin(ord($message[$i])), 8, '0', STR_PAD_LEFT);
        }
        $binMessage .= '00000000';

        // Check if the message will fit in the image
        if (strlen($binMessage) > ($width * $height)) {
            return response()->json(['error' => 'Message is too long to be hidden in the image']);
        }

        // Loop through each pixel in the image
        $binIndex = 0;
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // Get the RGB value of the current pixel
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // Replace the LSB of the blue component of the pixel with the next bit of the message
                $newB = ($b & 0xFE) | intval(substr($binMessage, $binIndex, 1));
                $binIndex++;

                // Set the new RGB value of the pixel
                $newColor = imagecolorallocate($img, $r, $g, $newB);
                imagesetpixel($img, $x, $y, $newColor);

                // Check if we have encoded the entire message
                if ($binIndex >= strlen($binMessage)) {
                    // Save the modified image to a new file
                    $encodedPath = $image->getPathname() . '.encoded.png';
                    imagepng($img, $encodedPath);

                    $path = $encodedPath;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    return response()->json(['base64' => $base64]);
                }
            }
        }

        // If we get here, the message was not successfully encoded
        return response()->json(['error' => 'Failed to encode message']);
    }


    public function createDecode(Request $request)
    {

        // Get the uploaded image file from the request
        $image = $request->file('image');

        // Open the image with the GD library
        $img = imagecreatefrompng($image->getPathname());

        // Get the image dimensions
        $width = imagesx($img);
        $height = imagesy($img);

        // Loop through each pixel in the image
        $binMessage = '';
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // Get the RGBA value of the current pixel
                $rgba = imagecolorat($img, $x, $y);
                $a = $rgba & 0xFF;

                // Extract the LSB of the alpha channel and append it to the binary message
                $binMessage .= decbin($a & 1);
            }
        }

        // Split the binary message into 8-bit chunks to get the ASCII codes
        $asciiCodes = str_split($binMessage, 8);

        // Convert the ASCII codes to characters
        $message = '';
        foreach ($asciiCodes as $ascii) {
            $message .= chr(bindec($ascii));
        }
        // Remove any null terminators from the message
        $message = rtrim($message, "\0");
//
//        // Return the decoded message as a JSON response
        $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
        $clearedText = Str::before($message, 'a27fa23e7316cb8fb7');
        $password = $request->input('password');
        if(Str::contains($message,'drtypoiytrdfvgbhjuhyg')){
            $pass = Str::between($message, 'a27fa23e7316cb8fb7', 'drtypoiytrdfvgbhjuhyg');
            if ($pass == md5($password) && $password!=null) {
                return response()->json(['message' => $clearedText]);
            } else{
                return response()->json(['message' => 'wrong password!!']);
            }
        }

        return response()->json(['message' => $clearedText]);
    }

    public function test(){
        $query = [
            "userName" =>'hidoctor_api',
            "password" => 'BXQJb6gUX7aSGCC',
            "currency" => "AMD",
            "amount" => 10,
            "orderNumber" => 100,
            "returnUrl" => 'http://hidoc.test/hy/ardshin-result',
            'language'=>'am',
            "description" => 'HIDOC'
        ];


        $response = Http::post('https://ipaytest.arca.am:8444/payment/rest/register.do', $query);
        return $response;
    }
    public function test1(){
        return redirect()->to('https://ipaytest.arca.am:8444/payment/merchants/hidoctor/payment_hy.html?mdOrder=c41cd7a9-de00-4d42-876b-2577ae37bbfd');
    }
}
