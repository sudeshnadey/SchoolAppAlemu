<?php
require_once '_config/dbconnect.php';
require_once 'require/header.php';
require_once 'classes/autoload.php';

require_once 'classes/order.class.php';
$Order  = new Order();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


  //  $school_name                  = htmlspecialchars(trim($_POST['school_name']));
  //  $school_contact               = htmlspecialchars(trim($_POST['school_contact']));
  //  $GSTIN                        = htmlspecialchars(trim($_POST['GSTIN']));
  //  $customer_id                  = htmlspecialchars(trim($_POST['customer_id']));
  //  $invoice_date                 = htmlspecialchars(trim($_POST['invoice_date']));
  //  $invoice_no                   = htmlspecialchars(trim($_POST['invoice_no']));
  //  $bill_to                      = htmlspecialchars(trim($_POST['bill_to']));
  //  $customer_GSTIN               = htmlspecialchars(trim($_POST['customer_GSTIN']));
  //  $ph_no                        = htmlspecialchars(trim($_POST['ph_no']));
  //  $customer_email               = htmlspecialchars(trim($_POST['customer_email']));
  
  $order_id                         = htmlspecialchars(trim($_GET['order_id']));
  $resultscart    = $Order->displaybill($order_id);

  foreach ($resultscart as $productdata) {
    $school_name             = $productdata['school_name'];
    $customer_id             = $productdata['user_id'];
    $product_name            = $productdata['product_name'];
    $Qty                     = $productdata['Qty'];
    $UnitPrice               = $productdata['original_price'];
    $total_amount	           = $productdata['total_amount'];
    $bill_to    	           = $productdata['name'];
    $ph_no      	           = $productdata['ph_no'];
    $customer_email      	   = $productdata['email'];
    $customer_address     	 = $productdata['address'];
    $invoice_date         	 = date("Y.m.d");
    $invoice_no         	   = $productdata['id'];

  }



//   define('FPDF_FONTPATH','font/');
//   define('FPDF_FONTPATH','font/');

  require('fpdf/fpdf.php');
  // ini_set("session.auto_start", 0);


  $pdf = new FPDF('P','mm','A4');

  $pdf->AddPage();
  /*output the result*/
  
  /*set font to arial, bold, 14pt*/
  $pdf->SetFont('Arial','B',20);
  
  /*Cell(width , height , text , border , end line , [align] )*/
  
  $pdf->Cell(71 ,10,'',0,0);
  $pdf->Cell(59 ,5,'Invoice',0,0);
  $pdf->Cell(59 ,10,'',0,1);


 $pdf->SetFont('Arial','',12);
  $pdf->Cell(190,10, $school_name, 1,2);
  $pdf->setXY(10,30);
  // $pdf->SetFont('Arial','',12);

  // $pdf->setXY(10,70);
$pdf->SetFont('Arial','',12);
  $pdf->MultiCell(0, 10,'');


  
  // $pdf->SetFont('Arial','B',15);
  // $pdf->Cell(71 ,5,'Address',0,0);
  // $pdf->Cell(130 ,5,'',0,0);
  // $pdf->Cell(59 ,5,'Details',0,1);
  
  $pdf->SetFont('Arial','',10);


  $pdf->Cell(130 ,5,' ',0,0);
  $pdf->Cell(25 ,5,'Customer ID:',0,0);
  $pdf->Cell(34 ,5,$customer_id,0,1);
  
  $pdf->Cell(130 ,5,' ',0,0);
  $pdf->Cell(25 ,5,'Invoice Date:',0,0);
  $pdf->Cell(34 ,5,$invoice_date,0,1);
   
  $pdf->Cell(130 ,5,'GSTIN - '.$GSTIN,0,0);
  $pdf->Cell(25 ,5,'Invoice No:',0,0);
  $pdf->Cell(34 ,5,$invoice_no,0,1);


  
  
  // $pdf->SetFont('Arial','B',15);
  // $pdf->Cell(130 ,5,'Bill To',0,0);
  // $pdf->Cell(59 ,5,'mousumi jana',0,0);
  // $pdf->SetFont('Arial','B',10);
  // $pdf->Cell(189 ,10,'',0,1);
  $pdf->Line(10, 59, 200, 59);

  // $pdf->MultiCell(0, 10,"Bill To:"."mousumi jana");
  // $pdf->Cell(0, 10, 'Bill To:');
  // $pdf->MultiCell(0, 20,"Subject : mousumi jana",0,1);
  // $pdf->SetFont('Arial','',12);
  // $pdf->MultiCell(0, 20,"{Company's contact details} : ");
  // $pdf->Cell(0, -5,"{Company's contact details} : ");  $customer_GSTIN 

  $pdf->setXY(10,85);
  $pdf->SetFont('Arial','B',10);
  $pdf->Text(10, 65,'Bill To : '.$bill_to);
  $pdf->Text(10,71,"GST IN :  ");
  $pdf->Text(10,77,"Address : ".$customer_address);
  $pdf->Text(10,83,"Mobile No. : ".$ph_no);
  $pdf->Text(10,89,"Email ID : ".$customer_email);

  // $pdf->MultiCell(0, -1,"Subject : mousumi jana");
  // $pdf->Cell(34 ,5,'mousumi jana',0,1);
  // $pdf->MultiCell(34 ,5,'mousumi jana',0,1);
  
  // $pdf->Cell(25 ,5,'Customer ID:',0,0);
  // $pdf->Cell(34 ,5,'mousumi jana',0,1);
  
  
  $pdf->Cell(50 ,10,'',0,1);
  
  $pdf->SetFont('Arial','B',10);
  /*Heading Of the table*/
  $pdf->Cell(10 ,10,'Sl',1,0,'C');
  $pdf->Cell(80 ,10,'Description',1,0,'C');
  $pdf->Cell(23 ,10,'Qty',1,0,'C');
  $pdf->Cell(30 ,10,'Unit Price',1,0,'C');
  $pdf->Cell(20 ,10,'Sales Tax',1,0,'C');
  $pdf->Cell(25 ,10,'Total',1,1,'C');/*end of line*/
  /*Heading Of the table end*/
  // $pdf->SetFont('Arial','',10);
  //     for ($i = 0; $i <= 10; $i++) {
  //     $pdf->Cell(10 ,15,$i,1,0);
  //     $pdf->Cell(80 ,15,'HP Laptop',1,0);
  //     $pdf->Cell(23 ,15,'1',1,0,'R');
  //     $pdf->Cell(30 ,15,'15000.00',1,0,'R');
  //     $pdf->Cell(20 ,15,'100.00',1,0,'R');
  //     $pdf->Cell(25 ,15,'15100.00',1,1,'R');
  //   }
  $pdf->Cell(10 ,35,1,1,0);
   $pdf->Cell(80 ,35,$product_name,1,0);
      $pdf->Cell(23 ,35,$Qty,1,0,'R');
      $pdf->Cell(30 ,35,$UnitPrice,1,0,'R');
      $pdf->Cell(20 ,35,'0',1,0,'R');
      $pdf->Cell(25 ,35,$total_amount,1,1,'R');
      
    // $pdf->Cell(100 ,10,'Sl',1,0,'C');
  // $pdf->Cell(118 ,6,'',0,0);
  $pdf->Cell(143 ,10,'Total Taxable Value',1,0, 'C');
  $pdf->Cell(45 ,10,$total_amount,1,1,'R');

 
  // $pdf->Cell(130 ,15,'Amount of IGST',0,0);
  // $pdf->Cell(25 ,15,'0.00%',0,0);

  $pdf->Cell(130 ,15,'Amount of IGST',0,0);
  $pdf->Cell(25 ,15,'0.00%',0,0);
  $pdf->Cell(34 ,5,'',0,1);
  
  $pdf->Cell(130 ,15,'Amount of IGST',0,0);
  $pdf->Cell(25 ,15,'0.00%',0,0);
  $pdf->Cell(34 ,5,'',0,1);

  $pdf->Cell(130 ,15,'Amount of IGST',0,0);
  $pdf->Cell(25 ,15,'0.00%',0,0);
  $pdf->Cell(34 ,15,'',0,1);

  $pdf->Cell(143 ,10,'Total Invoice Value',1,0, 'C');
  $pdf->Cell(45 ,10,$total_amount,1,1,'R');


  $pdf->Cell(130 ,15,'E & O.E',0,0);
  $pdf->Cell(25 ,15,'',0,0);
  $pdf->Cell(34 ,10,'',0,1);
  
  $pdf->MultiCell(192, 5,'Declaration:- ',0,0);
  // $pdf->MultiCell(170 ,10,'',0,0);
  $pdf->Cell(34 ,0,'',0,1);

  // $pdf->Cell(120 ,5,'',0,0);
  // $pdf->Cell(25 ,15,'For {Company NameDeclaration}',0,0);
  // $pdf->Cell(34 ,10,'',0,1₹);

  $pdf->SetFont('Arial','B',10 );
  $pdf->Cell(0, 10,"For {Company NameDeclaration}",0,0,'R');
//   $pdf->setXY(170,50);

//   $pdf->SetLeftMargin(10);
  $pdf->Ln(1);
  $pdf->SetFont('Arial','B',10);
  $pdf->Cell(0, 25, '',0,0,'R');
  $pdf->Ln(20);

  $pdf->Cell(10,0,'Terms and Conditions',0,0);
  $pdf->Cell(34 ,10,'',0,1);
  $pdf->Cell(10,0,'1',0,0);
  $pdf->Cell(34 ,10,'',0,1);
  $pdf->Cell(10,0,'2',0,0);

  // $pdf->Cell(25 ,15,'0.00%',0,0);
  // $pdf->Cell(34 ,15,'',0,1);

  $pdf->SetFont('Arial','B',10 );
  $pdf->Cell(0, 10,"Authorised Signatory",0,0,'R');
  
  
  $pdf->Output('TAX-INVOICE.pdf', 'D');






// } catch (\Exception $e) {
//   // Token verification failed
//   http_response_code(405); 
//   echo json_encode(array('status' => 'error', 'message' => ' Token does not match'));
//   exit;
// }

}else {
    http_response_code(405); // method not allowed
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}
?>