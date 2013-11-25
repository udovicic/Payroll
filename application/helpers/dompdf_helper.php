<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Render PDF
*
* @param string $html HTML for rendering
* @param string $filename Output filename
* @param bool $stream If true, output will be stream to browser instead of file
* @return $string PDF stream if $stream is true
*/
function pdf_create($html, $filename='', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}
