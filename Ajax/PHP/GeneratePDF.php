<?php
	
	header('Content-Type: application/json');
	
	session_start();
	require_once '../../vendor/autoload.php';
	include '../../Functions/functions.php';
	
	use Fpdf\Fpdf;
	
	class PDF extends FPDF {
		
		function Header() {
			global $titre;
			
			// Arial gras 15
			$this->SetFont('Arial', 'B', 15);
			// Calcul de la largeur du titre et positionnement
			$w = $this->GetStringWidth($titre) + 6;
			$this->SetX((210 - $w) / 2);
			// Couleurs du cadre, du fond et du texte
			$this->SetDrawColor(0, 80, 180);
			$this->SetFillColor(230, 230, 0);
			$this->SetTextColor(220, 50, 50);
			// Epaisseur du cadre (1 mm)
			$this->SetLineWidth(1);
			// Titre
			$this->Cell($w, 9, $titre, 1, 1, 'C', TRUE);
			// Saut de ligne
			$this->Ln(10);
		}
		
		function LoadData($id) {
			$participerManager = new App\ParticiperManager();
			$membreManager = new \App\MembresManager();
			$participer = $participerManager->readParticipant($id);
			if (!empty($participer)) {
				foreach($participer as $v) {
					$membre = $membreManager->readMembreTab($v["IDmembre"]);
					$data[] = $membre;
				}
				return $data;
			}
			return FALSE;
		}
		
		function BasicTable($header, $data) {
			// En-tête
			$this->Cell(68, 10, $header[0], 1);
			$this->Cell(35, 10, $header[1], 1);
			$this->Cell(35, 10, $header[2], 1);
			$this->Cell(35, 10, $header[3], 1);
			$this->Cell(20, 10, $header[4], 1);
			$this->Ln();
			// Données
			foreach($data as $v) {
				$this->Cell(68, 6, $v["Email"], 1);
				$this->Cell(35, 6, $v["Nom"], 1);
				$this->Cell(35, 6, $v["Prenom"], 1);
				$this->Cell(35, 6, $v["Telephone"], 1);
				$this->Cell(20, 6, "", 1);
				$this->Ln();
			}
		}
	}
	
	if (isset($_POST["idevent"])) {
		
		$pdf = new PDF();
		
		$header = [
			'Email',
			'Nom',
			'Prenom',
			'Telephone',
			'Paiement',
		];
		
		$data = $pdf->LoadData($_POST["idevent"]);
		if ($data !== FALSE) {
			$titre = 'Liste des participants';
			$pdf->SetFont('Arial', '', 10);
			$pdf->SetTitle($titre);
			$pdf->AddPage();
			$pdf->BasicTable($header, $data);
			$nameFile = date("Ymdhis") . $_POST["idevent"] . ".pdf";
			$pdf->Output("../../Files/ListePDF/" . $nameFile, "F");
			
			echo json_encode([
				"text" => "PDF Généré !",
				"name" => $nameFile,
			]);
		} else {
			echo json_encode([
				"text" => "Il n'y a pas de participants !",
			]);
		}
	} else {
		echo json_encode([
			"text" => "Une erreur est survenu, réessayez !",
		]);
	}