<?php
include_once("../vendor/autoload.php");

class Bill{

    public function getBill($idFactura,$arrayDataUsers,$arrayDataBill){

        $document = new \PhpOffice\PhpWord\PhpWord();
        //Nueva sección
        $section = $document ->addSection();

        //Cabecera de la factura con la fecha
        $header = $section->createHeader();
        $header->addImage('../Public/Img/fav-ico_nofondo_2.png',
            array('align' => 'end')
            );
        $date= date("F jS, Y", time());    
        $header-> addText(
            "Factura  ".$date ,
            array('name' => 'Arial', 
            'size' => 16 ,
            'align' => 'start',
            "positioning"=>"absolute")
        );


        // Tabla de la factura
        $table =$section->addTable();
        $table->addRow();
        $table->addCell(4000)->addText("Nombre producto");
        $table->addCell(4000)->addText("Unidades");
        $table->addCell(4000)->addText("Precio");
        $total = 0;
        for ($i=0; $i < count($arrayDataBill); $i++) { 
            $table->addRow();
            $table->addCell(4000)->addText($arrayDataBill[$i]["nombre"]);
            $table->addCell(4000)->addText($arrayDataBill[$i]["unidades"]);
            $table->addCell(4000)->addText($arrayDataBill[$i]["precioTotal"]);
            $total = $total + $arrayDataBill[$i]["precioTotal"];
        }   
        $table->addRow();
        $table->addCell(4000)->addText("===============================================================");
        $table->addRow();
        $table->addCell(6000)->addText("Precio total");
        $table->addCell(6000)->addText($total." €");

        $footer = $section->createFooter();
        $footer-> addText(
            "Gracias por su compra, esperemos que le haya gustado, ya puede ir a recogerla ",
            array('name' => 'Arial', 
            'size' => 16 ,
            'align' => 'start',
            "positioning"=>"absolute",
            "margintop"=>800)
        );
        $objWriter =\PhpOffice\PhpWord\IOFactory::createWriter($document,"Word2007");
        $filename=$arrayDataUsers['nombre']." ".$arrayDataUsers['apellidos']." - Factura EMOP.doc";
        $objWriter->save("../Public/Bills/".$filename);
        return $filename;
    }
}
