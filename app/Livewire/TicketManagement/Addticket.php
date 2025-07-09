<?php

namespace App\Livewire\TicketManagement;

use App\Models\User;
use App\Models\Ticket;
use Livewire\Component;
use App\Models\Violation;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\TicketCounter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Addticket extends Component
{


    public $tct_number;
    public $ticket;
    public $plate_number;
    public $violation_ids = [];



    public $selectedViolation;

    public $allViolations;




    public $options = [];  // Stores all violation types
    public $selectedOptions = [];  // Stores selected violation types


    public $ticket_id;
    public $tct_date;
    public $time;
    public $fname;
    public $lname;
    public $mname;
    public $xname;


    public $license_number;
    public $engine_number;
    public $chasis_number;
    public $mv_type;
    public $street_address;

    //
    // public $municipality;
    public $plate_number_form;
    public $place_of_citation;
    public $mv_reg_number;
    public $con_item;
    public $ticket_by;
    public $owner_vehicle;
    public $paid_date;
    public $or_number;
    public $search_ticket;
    public $tct_number_form;
    public $dob;
    public $contact_number;
    public $pdfUrl;



    public $violation_id;
    public $regionPSGCcode;
    public $provincePSGCcode;
    public $municipalPSGCcode;
    public $brgyPSGCcode;
    public $enforcerId;
    public $totalTicketsUsed;
    public $totalTicketsissued;

    public function mount()
    {
        $user = Auth::user();
        $this->enforcerId = $user->id;
        $this->totalTicketsUsed = User::find($user->id)?->tickets()->count() ?? 0;

        $range = DB::table('ticket_ranges')->where('user_id', $this->enforcerId)
            ->first();



        $this->totalTicketsissued = $range->end_number - $range->start_number + 1;



        $this->allViolations = Violation::all();


        $this->options = DB::table('violations')
            ->select('id as id', 'violation_type')
            ->get()
            ->toArray();
    }



    #[Computed()]
    public function region2()
    {
        return DB::table('geography')
            ->where('level', 'Reg')
            ->get(["psgccode", "name"]);
    }

    #[Computed()]
    public function province()
    {
        return DB::table('geography')
            ->where(function ($query) {
                $query->where('level', 'Prov')
                    ->orWhere('level', 'Dist');
            })->where('region', $this->regionPSGCcode)
            ->get(["psgccode", "name"]);
    }


    #[Computed()]
    public function municipality()
    {
        return DB::table('geography')
            ->where(function ($query) {
                $query->where('level', 'Mun')
                    ->orWhere('level', 'City');
            })->where('province', $this->provincePSGCcode)
            ->get(["psgccode", "name"]);
    }

    #[Computed()]
    public function barangay()
    {
        return DB::table('geography')
            ->where('municipality', $this->municipalPSGCcode)
            ->where('level', 'Bgy')
            ->get(["psgccode", "name"]);
    }




    public function store()
    {
        $validated = $this->validate([
            'tct_date' => 'required',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'regionPSGCcode' => 'required|string',
            'provincePSGCcode' => 'required|string',
            'municipalPSGCcode' => 'required|string',
            'selectedOptions' => 'required|array|min:1',

        ]);



        $user = Auth::user();
        $ticketNumber = $user->ticketnumber(); //  Auto-generate ticket number

        $violationDetails = [
            'contact_number' => $this->contact_number,
            'license_number' => $this->license_number,
            'engine_number' => $this->engine_number,
            'chasis_number' => $this->chasis_number,
            'plate_number' => $this->plate_number,
            'mv_type' => $this->mv_type,
            'place_of_citation' => $this->place_of_citation,
            'mv_reg_number' => $this->mv_reg_number,
            'con_item' => $this->con_item,
            'owner_vehicle' => $this->owner_vehicle,
        ];

        $data = new Ticket();
        $data->tct_number = $ticketNumber;
        $data->tct_date = $validated['tct_date'];
        $data->fname = $validated['fname'];
        $data->lname = $validated['lname'];
        $data->mname = $this->mname;
        $data->xname = $this->xname;
        $data->dob = $this->dob;
        $data->street_address = $this->street_address;
        $data->region = $validated['regionPSGCcode'];
        $data->municipality = $validated['municipalPSGCcode'];
        $data->province = $validated['provincePSGCcode'];
        $data->barangay = $this->brgyPSGCcode;
        $data->ticket_by = $user->id;
        $data->encoded_by = $user->id;
        $data->violation_details = $violationDetails;

        $data->save();

        foreach ($this->selectedOptions as $violationId) {
            DB::table('transactions')->insert([
                'ticket_id' => $data->id,
                'user_id' => $user->id,
                'violation_id' => $violationId,
            ]);
        }

        $this->generatePdf($data->id);
    }

    public function generatePdf($ticketId)
    {


        // Save the signature before generating the PDF
        $this->signatureUpdated();

        $user = Auth::user();
        $ticket = Ticket::withTrashed()->with('violations')->find($ticketId);

        $violations = $ticket->violations ?? collect();
        $totalViolation = $violations->count();
        $totalFine = $totalViolation * 200;

        // Generate barcode
        $barcodeData = $ticket->tct_number;
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = $generator->getBarcode($barcodeData, $generator::TYPE_CODE_128);
        $barcodePath = storage_path("app/public/barcode_{$barcodeData}.png");
        file_put_contents($barcodePath, $barcodeImage);

        // Estimate height
        $totalHeight = 160 + ($violations->count() * 8);
        $pdf = new Fpdf('P', 'mm', [58, $totalHeight]);
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage();

        // Header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, 'Republic of the Philippines', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 5, 'Municipality of Bayambang', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, 'Local Government Unit', 0, 1, 'C');
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 5, 'Traffic Citation Ticket', 0, 1, 'C');
        $pdf->Ln(1);
        $pdf->Line(5, $pdf->GetY(), 53, $pdf->GetY());
        $pdf->Ln(2);

        // Ticket info
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'Ticket No:', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, $ticket->tct_number, 0, 1);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(12, 5, 'Name:', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, $ticket->fname . ' ' . $ticket->lname, 0, 1);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'Date:', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, $ticket->tct_date, 0, 1);

        // Violations
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, 'Recorded Offenses:', 0, 1);
        $pdf->SetFont('Arial', '', 8);

        if ($violations->isEmpty()) {
            $pdf->Cell(0, 5, 'None', 0, 1);
        } else {
            foreach ($violations as $violation) {
                $violationX = 6;
                $fineX = 42;
                $yStart = $pdf->GetY();
                $pdf->SetXY($violationX, $yStart);
                $pdf->MultiCell(34, 4, $violation->violation_type, 0, 'L');
                $yEnd = $pdf->GetY();
                $pdf->SetXY($fineX, $yStart);
                $pdf->Cell(0, $yEnd - $yStart, number_format($violation->amount, 2), 0, 1, 'R');
            }
        }

        // Totals
        $pdf->Ln(1);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(30, 5, 'Total Fine:', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, number_format($totalFine, 2), 0, 1);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 5, 'Officer:', 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, strtoupper(substr($user->firstname, 0, 1)) . '. ' . $user->lastname, 0, 1);

        // Signature
        $signatureFile = storage_path('app/public/signatures/signature_' . $ticketId . '.png');
        if (file_exists($signatureFile)) {
            $pdf->Ln(8);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(0, 5, 'Violator Signature:', 0, 1, 'L');
            $pdf->Image($signatureFile, 10, $pdf->GetY(), 30);
            $pdf->Ln(12);
        }

        // Note
        $pdf->Ln(2);
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->MultiCell(0, 4, "Note: Please respond to this citation within 3 days to avoid additional penalties. You may pay the fine or contest the ticket in court.");

        // Barcode
        $pdf->Ln(4);
        $barcodeWidth = 40;
        $barcodeX = (58 - $barcodeWidth) / 2;
        $pdf->Image($barcodePath, $barcodeX, $pdf->GetY(), $barcodeWidth);
        $pdf->Ln(12);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(0, 4, 'Ticket #: ' . $barcodeData, 0, 1, 'C');

        // Cleanup
        @unlink($barcodePath);

        // Output
        $pdfContent = base64_encode($pdf->Output('S'));
        $this->dispatch('open-pdf', pdf: $pdfContent);

        $this->reset();
    }


    // Function to toggle selection of an option
    public function toggleOption($id)
    {
        if (in_array($id, $this->selectedOptions)) {
            $this->selectedOptions = array_diff($this->selectedOptions, [$id]);
        } else {
            $this->selectedOptions[] = $id;
        }
    }
    #[Computed()]
    public function user_ticket_by()
    {
        return User::whereIn('user_role', ['enforcer', 'pnp_wawa', 'pnp_poblacion'])->get();
    }

    public function render()
    {



        return view('livewire.ticket-management.addticket', [
            'allViolations' => Violation::all(),

        ]);
    }
}
