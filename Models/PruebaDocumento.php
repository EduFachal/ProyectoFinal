<?php
require_once '[rutaDocxpresso]/CreateDocument.inc';
$doc = new Docxpresso\createDocument(array('template' => 'template.odt'));
$format = '.pdf';//.odt, .doc, .docx, .odt, .rtf
$doc->replace(array('nombre' => array('value' => 'Carlos')));
$html = '<html><body><p><img src="http://www.docxpresso.com/themes/docxpresso/images/logo_docxpresso.png"></p></body></html>';

$doc->html(array('html'=>$html));
$doc->render('sample' . $format);
echo '<a href="' . 'sample' . $format . '">Descargar Documento</a>';