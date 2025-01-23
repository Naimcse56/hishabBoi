<?php

namespace Modules\Base\App\Services;

use Illuminate\Support\Facades\Http;

class SecurityService
{
    public function verify($domain, $purchaseCode)
    {
        $validation_url = 'https://advocatebari.com/check_activation.php';

        // Prepare the data to be sent
        $data = array(
            'domain' => $domain,
            'purchase_code' => $purchaseCode
        );

        // Initialize cURL session
        $ch = curl_init($validation_url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Receive response
        curl_setopt($ch, CURLOPT_POST, true); // Use POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Pass the data as URL-encoded string

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        }
        // Close the cURL session
        curl_close($ch);
        // Purchase code is invalid or request failed
        echo $response;
    }
}
