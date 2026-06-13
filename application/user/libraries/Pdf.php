<?php 

require_once APPPATH.'third_party/fpdf/fpdf.php'; 
class Pdf extends FPDF {
	private $widths;
	private $aligns;

	  protected $imageKey = '';
      protected $border_r = 41;
      protected $border_g = 128;
      protected $border_b = 185;

  public function setBorderColor($r, $g, $b) {
      $this->border_r = $r;
      $this->border_g = $g;
      $this->border_b = $b;
  }

  public function Header() {
      // --- DRAW PREMIUM PAGE BORDER ---
      $this->SetDrawColor($this->border_r, $this->border_g, $this->border_b); // Dynamic border color
      $this->SetLineWidth(1.0); // 1mm thickness
      $this->Rect(5, 5, 200, 287, 'D'); // A4 size is 210x297, margin 5mm all around
      $this->SetLineWidth(0.2); // Reset line width to default
      $this->SetDrawColor(0, 0, 0); // Reset drawing color
  }

  public function setImageKey($key){
    $this->imageKey = $key;
  }

  public function Rowimgcs($data, $foto){
    $nb=0;
    for($i=0;$i<count($data);$i++)
      $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));

      $a=50*count($foto);

      $b=5*$nb;

      if ($a > $b) {
      	$h=$a;
      }else{
      	$h=$b;
      }
      $this->CheckPageBreak($h);
      for($i=0;$i<count($data);$i++){
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        $x=$this->GetX();
        $y=$this->GetY();
        $this->Rect($x,$y,$w,$h);

        //modify functions for image 

        if(!empty($this->imageKey) && $i== $this->imageKey){
          $ih = $h - 0.5;
          $iw = $w - 0.5;
          $ix = $x + 0.25;
          $iy = $y + 0.25;
          $ft = null;
          
          for ($j=0; $j < count($foto); $j++) { 
          	$ft .= $this->Image ($foto[$j],null,null,50,50);
          }

          $this->MultiCell($w,5, $ft ,0,$a);

        }
        else
          $this->MultiCell($w,5,$data[$i],0,$a);
        $this->SetXY($x+$w,$y);
      }
      $this->Ln($h);
    }

  public function Rowimg($data){
    $nb=0;
    for($i=0;$i<count($data);$i++)
      $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
      $h=190;

      $this->CheckPageBreak($h);
      for($i=0;$i<count($data);$i++){
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        $x=$this->GetX();
        $y=$this->GetY();
        $this->Rect($x,$y,$w,$h);

        //modify functions for image 

        if(!empty($this->imageKey) && $i== $this->imageKey){
          $ih = $h - 0.5;
          $iw = $w - 0.5;
          $ix = $x + 0.25;
          $iy = $y + 0.25;
          $this->MultiCell($w,5,$this->Image ($data[$i],null, null, 50, 50) ,0,$a);
        }
        else
          $this->MultiCell($w,5,$data[$i],0,$a);
        $this->SetXY($x+$w,$y);
      }
      $this->Ln($h);
    }

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	function Rowdb($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			// $this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],'LRB', 'C');
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	function Rowd($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			// $this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],'LR', 'C');
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function Rows($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			//$this->Rect($x,$y,$w,$h['F']);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function Footer()
	{
    // Position at 1.5 cm from bottom
		$this->SetY(-15);
    // Arial italic 8
		$this->SetFont('Arial','I',8);
    // Page number
		// $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb} halaman', 0, 0, 'R');
	}

	function Row_head($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,0,0);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);

		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}

	function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

	function myCell($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>38){
			$txt=str_split($t,38);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','B',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'B',0,'L',0);
		}
	}
	function myCellDIR($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>40){
			$txt=str_split($t,40);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','B',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'B',0,'L',0);
		}
	}

	function myCellDIR1($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>13){
			$txt=str_split($t,13);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','BR',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'RB',0,'L',0);
		}
	}

	function myCellDIR2($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>14){
			$txt=str_split($t,14);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','BR',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'RB',0,'L',0);
		}
	}
	function myCustoms($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>38){
			$txt=str_split($t,38);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'',0,0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,0,0,'L',0);
		}
	}
	function myKontrak($w,$h,$x,$t){
		$height=$h/2;
		$first=$height+1;
		$second=$height+$height+$height+3;
		$tiga= $second+4;
		$len=strlen($t);
		if($len>15){
			$txt=str_split($t,12);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetFont('Times', 'BU', 10);
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			// $this->SetX($x);
			// $this->Cell($w,$tiga,$txt[2],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'',0,0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,0,0,'L',0);
		}
	}
	function myCustoms2($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>38){
			$txt=str_split($t,38);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'',0,1,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,0,1,'L',0);
		}
	}
	function myCell2($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>16){
			$txt=str_split($t,16);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','BR',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'RB',0,'L',0);
		}
	}
	function myCellku($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>8){
			$txt=str_split($t,8);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','BR',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'RB',0,'L',0);
		}
	}
	function myCell3($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>10){
			$txt=str_split($t,10);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'','B',0,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,'B',0,'L',0);
		}
	}
	function myCell4($w,$h,$x,$t){
		$height=$h/3;
		$first=$height+2;
		$second=$height+$height+$height+3;
		$len=strlen($t);
		if($len>18){
			$txt=str_split($t,18);
			$this->SetX($x);
			$this->Cell($w,$first,$txt[0],'','','');
			$this->SetX($x);
			$this->Cell($w,$second,$txt[1],'','','');
			$this->SetX($x);
			$this->Cell($w,$h,'',0,1,'L',0);
		}
		else{
			$this->SetX($x);
			$this->Cell($w,$h,$t,0,1,'L',0);
		}
	}

	

}




?>