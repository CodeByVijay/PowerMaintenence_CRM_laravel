<?php

namespace App\Http\Controllers\leads;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadConcessionCard;
use App\Models\LeadIdentificationCardDetail;
use App\Models\LeadNote;
use App\Models\LeadSource;
use App\Models\Retailer;
use App\Models\StreetType;
use App\Models\UnitType;
use App\Models\User;
use DataTables;
use Exception;
use Illuminate\Http\Request;

class LeadController extends Controller
{

    public function index()
    {
        $data['Retailers'] = Retailer::where('active', "Yes")->select('id', 'name')->get();
        $data['LeadSources'] = LeadSource::where('status', 1)->select('id', 'name')->get();
        $data['StreetTypes'] = StreetType::select('id', 'longName', 'shortName')->get();
        $data['UnitTypes'] = UnitType::select('id', 'longName', 'shortName')->get();
        return view('content.leads.create-lead', $data);

    }
    public function leads()
    {
        $data['users'] = User::where(['access_type' => 2, 'status' => 1])->get();
        return view('content.leads.lead-list', $data);
    }
    public function leadList(Request $request)
    {
        if ($request->ajax()) {
            $leads = Lead::leftjoin('lead_identification_card_details as identity', 'identity.leadId', '=', 'leads.id')->leftjoin('lead_concession_cards as concession', 'concession.leadId', '=', 'leads.id')->leftjoin('users as c_user', 'c_user.id', '=', 'leads.createdBy')->leftjoin('users as u_user', 'u_user.id', '=', 'leads.updatedBy')->leftjoin('users as at_user', 'at_user.id', '=', 'leads.assignedTo')->leftjoin('users as aby_user', 'aby_user.id', '=', 'leads.assignedBy')->select('leads.id as lead_id', 'leads.firstName as lead_firstName', 'leads.lastName as lead_lastName', 'leads.homePhone as homePhone', 'leads.phyPostcode as postcode', 'c_user.first_name as created_fname', 'c_user.last_name as created_lname', 'leads.leadSource', 'leads.status as lead_status', 'u_user.first_name as modified_fname', 'u_user.last_name as modified_lname', 'at_user.first_name as assignTo_user_fname', 'at_user.last_name as assignTo_user_lname', 'leads.updated_at as modified_date', 'leads.salesType as ac_type')->orderBy('leads.created_at', 'desc')->get();

            return Datatables::of($leads)
                ->addIndexColumn()
                ->addColumn('checkBox', function ($row) {
                    $checkBox = '<input class="form-check-input singlecheckbox" type="checkbox" name="singlecheckbox" data-id="' . $row->lead_id . '" style="width: 20px !important; height: 20px !important;">';
                    return $checkBox;
                })
                ->addColumn('name', function ($row) {
                    $name = $row->lead_firstName . ' ' . $row->lead_lastName;
                    return $name;
                })
                ->addColumn('created_on', function ($row) {
                    $created_name = $row->created_fname . ' ' . $row->created_lname;
                    return $created_name;
                })
                ->addColumn('callback', function ($row) {
                    $callback = '-';
                    return $callback;
                })
                ->addColumn('utilities', function ($row) {
                    $utilities = '-';
                    return $utilities;
                })
                ->addColumn('modified_by', function ($row) {
                    $modified_by = $row->modified_fname . ' ' . $row->modified_lname;
                    $modified_by = !empty($row->modified_fname) ? $modified_by : '-';
                    return $modified_by;
                })
                ->addColumn('assign_to', function ($row) {
                    $assign_to = $row->assignTo_user_fname . ' ' . $row->assignTo_user_lname;
                    $assign_to = !empty($row->assignTo_user_fname) ? $assign_to : '-';
                    return $assign_to;
                })
                ->addColumn('modified_date', function ($row) {
                    $modified_date = !empty($row->modified_date) ? date('d-M-Y h:i A', strtotime($row->modified_date)) : '-';
                    return $modified_date;
                })

                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route("lead-edit", ['id' => $row->lead_id]) . '" class="edit btn btn-success btn-sm mb-2" title="Edit"><i class="bx bx-edit"></i></a>';
                    $actionBtn .= '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm"';
                    $actionBtn .= ' onclick="leadDelete(' . $row->lead_id . ')" title="Delete"><i class="bx bx-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['checkBox', 'name', 'created_on', 'callback', 'utilities', 'modified_by', 'assign_to', 'modified_date', 'action'])
                ->make(true);
        }
    }

    public function createlead(Request $request)
    {
        // printData($request->all());
        // die();

        $request->validate([
            'title' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'ContactNumber' => 'required',
            'energy' => 'required',
            'gas' => 'required',
            'internet' => 'required',
            'concession' => 'required',
            'sales_type' => 'required',
            'account_type' => 'required',
            'lead_source' => 'required',
            'street_number' => 'required',
            'street_name' => 'required',
            // 'street_type_suffix' => 'required',
            'suburb' => 'required',
            'state' => 'required',
            'postcode' => 'required',
        ]);
        if ($request->energy == "Yes") {
            $request->validate([
                'eleRetailer' => 'required',
            ], [
                'eleRetailer.required' => 'The current electricity retailer field is required.',
            ]);
        }

        if ($request->gas == "Yes") {
            $request->validate([
                'gasRetailer' => 'required',
            ], [
                'gasRetailer.required' => 'The current gas retailer field is required.',
            ]);
        }

        if ($request->id_number != "" && !empty($request->id_number) && $request->id_type !== "Passport") {
            $request->validate([
                'id_type' => 'required',
                'id_expiry_date' => 'required',
                'id_state' => 'required',
            ], [
                'id_type.required' => 'The id type field is required.',
            ]);
        }

        if ($request->id_number != "" && !empty($request->id_number) && $request->id_type === "Passport") {
            $request->validate([
                'id_type' => 'required',
                'id_expiry_date' => 'required',
                'issue_country' => 'required',
            ], [
                'id_type.required' => 'The id type field is required.',
            ]);
        }

        if (isset($request->concession) && $request->concession == "Yes" && !empty($request->con_card_number)) {
            $request->validate([
                'con_card_type' => 'required',
                'con_card_start_date' => 'required',
                'con_card_end_date' => 'required',
            ], [
                'con_card_type.required' => 'The oncession card type field is required.',
                'con_card_start_date.required' => 'The oncession card start date field is required.',
                'con_card_end_date.required' => 'The oncession card end date field is required.',
            ]);
        }

        if ($request->sales_type == "Move-In") {
            $request->validate([
                'move_in_date' => 'required',
            ], [
                'move_in_date.required' => 'The move in date field is required.',
            ]);
        }
        try {
            if (isset($request->lead_id) && $request->lead_id != null) {
                $leadData = Lead::find($request->lead_id);
            } else {
                $leadData = new Lead();
            }

            $leadData->title = $request->title;
            $leadData->firstName = $request->firstName;
            $leadData->lastName = $request->lastName;
            $leadData->homePhone = $request->ContactNumber;
            $leadData->email = $request->email;
            $leadData->dateOfBirth = !empty($request->dateofbirth) && $request->move_in_date != "01-01-1970" ? setFormatDate($request->dateofbirth) : null;
            $leadData->energy = $request->energy;
            $leadData->gas = $request->gas;
            $leadData->broadband = $request->internet;
            $leadData->currentElectricityRetailer = $request->eleRetailer;
            $leadData->currentGasRetailer = $request->gasRetailer;
            $leadData->salesType = $request->sales_type;
            $leadData->leadSource = $request->lead_source;
            $leadData->connectionDate = !empty($request->move_in_date) && $request->move_in_date != "01-01-1970" ? setFormatDate($request->move_in_date) : null;
            $leadData->type = 'Lead';
            $leadData->createdBy = auth()->user()->id;
            if (isset($request->lead_id) && $request->lead_id != null) {
                $leadData->updatedBy = auth()->user()->id;
            }
            $leadData->accountType = $request->account_type;
            $leadData->notes = $request->new_notes;
            $leadData->phyUnitnumber = $request->unit_number;
            $leadData->phyUnitType = $request->unit_type;
            $leadData->phyLotnumber = $request->lot_number;
            $leadData->phyStreetnumber = $request->street_number;
            $leadData->phyStreetNumberSuffix = $request->street_number_suffix;
            $leadData->phyStreetSuffix = $request->street_name_suffix;

            $leadData->phyStreetname = $request->street_name;
            $leadData->phyStreetType = $request->street_type_suffix;
            $leadData->phySuburb = $request->suburb;
            $leadData->phyState = $request->state;
            $leadData->phyPostcode = $request->postcode;
            $leadData->promocode = $request->promo_code;
            $leadData->hasConcession = $request->concession;
            if (isset($request->lead_id) && $request->lead_id != null) {
                $leadData->updated_at = now();
            } else {
                $leadData->created_at = now();
                $leadData->updated_at = null;
            }

            $leadData->save();
            if ($leadData->id) {

                // Send Notification
                if (empty($request->lead_id) && $request->lead_id == null) {
                    $notifyTxt = "New lead created At " . date('d-M-y, h:i A');
                    sendLeadsNotification($leadData->id, $notifyTxt, 1);
                }
                // Send Notification End

                $lead_id = $leadData->id;
                // printData($lead_id);
                // die();
                $edit_id = isset($request->lead_id) && $request->lead_id != null ? $request->lead_id : null;

                if ($request->id_number != "" && !empty($request->id_number)) {
                    $this->identificationDetails($request, $lead_id, $edit_id);
                }
                if (isset($request->concession) && $request->concession == "Yes") {
                    $this->concessionCardData($request, $lead_id, $edit_id);
                }
                if (isset($request->new_notes) && $request->new_notes != "") {
                    $this->notes($request, $lead_id, auth()->user()->id);
                }
            }
            return redirect()->route('lead-leads-list')->with('success', 'Lead successfully saved.');
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage())->withInput();
        }

    }

    public function concessionCardData($data, $lead_id, $edit_id = null)
    {
        if (isset($edit_id) && $edit_id != null) {
            $cardData = LeadConcessionCard::where('leadID', $edit_id)->first();
        } else {
            $cardData = new LeadConcessionCard();
        }
        $cardData->leadID = $lead_id;
        $cardData->cardType = $data->con_card_type;
        $cardData->cardNumber = $data->con_card_number;
        $cardData->card_start_date = !empty($data->con_card_start_date) && $data->con_card_start_date != "01-01-1970" ? setFormatDate($data->con_card_start_date) : null;
        $cardData->card_end_date = !empty($data->con_card_end_date) && $data->con_card_end_date != "01-01-1970" ? setFormatDate($data->con_card_end_date) : null;
        $cardData->save();
        return true;
    }

    public function identificationDetails($data, $lead_id, $edit_id = null)
    {
        if (isset($edit_id) && $edit_id != null) {
            $identification = LeadIdentificationCardDetail::where('leadID', $edit_id)->first();
            if (empty($identification)) {
                $identification = new LeadIdentificationCardDetail();
            }
        } else {
            $identification = new LeadIdentificationCardDetail();
        }

        $identification->leadID = $lead_id;
        $identification->id_type = $data->id_type;
        $identification->id_number = $data->id_number;
        $identification->id_expiry_date = !empty($data->id_expiry_date) && $data->id_expiry_date != "01-01-1970" ? setFormatDate($data->id_expiry_date) : null;
        $identification->id_issue_state = isset($data->id_state) ? $data->id_state : null;
        $identification->id_issue_country = isset($data->issue_country) ? $data->issue_country : null;
        $identification->save();
        return true;
    }
    public function notes($data, $lead_id, $user_id, $edit_id = null)
    {
        $notes = new LeadNote();
        $notes->leadID = $lead_id;
        $notes->notes = $data->new_notes;
        $notes->userID = $user_id;
        $notes->save();
        return true;
    }

    public function editForm($id)
    {
        $data['leads'] = Lead::leftjoin('lead_identification_card_details as identity', 'identity.leadId', '=', 'leads.id')->leftjoin('lead_concession_cards as concession', 'concession.leadId', '=', 'leads.id')->where('leads.id', $id)->select('leads.*', 'identity.id_type', 'identity.id_number', 'identity.id_expiry_date', 'identity.id_issue_state', 'identity.id_issue_country', 'concession.cardType', 'concession.cardNumber', 'concession.card_start_date', 'concession.card_end_date')->first();
        $data['notes'] = LeadNote::join('users', 'users.id', '=', 'lead_notes.userID')->where('lead_notes.leadID', $id)->select('lead_notes.*', 'users.first_name', 'users.last_name')->orderBy('lead_notes.created_at', 'desc')->get();
        $data['Retailers'] = Retailer::where('active', "Yes")->select('id', 'name')->get();
        $data['LeadSources'] = LeadSource::where('status', 1)->select('id', 'name')->get();
        $data['StreetTypes'] = StreetType::select('id', 'longName', 'shortName')->get();
        $data['UnitTypes'] = UnitType::select('id', 'longName', 'shortName')->get();
        return view('content.leads.edit-lead', $data);
    }

    public function assignLeads(Request $request)
    {
        // printData($request->all());
        try {
            $assign = Lead::whereIn('id', $request->lead_ids)->update([
                'assignedTo' => $request->user_id,
                'assignedBy' => auth()->user()->id,
                'updatedBy' => auth()->user()->id,
                'assigned_at' => now(),
                'status' => "Assigned",
            ]);
            if ($assign) {
                // Send Notification
                foreach ($request->lead_ids as $lead_id) {
                    $notifyTxt = "New lead assigned At " . date('d-M-y, h:i A');
                    sendLeadsNotification($lead_id, $notifyTxt, 2, $request->user_id);
                }
                // Send Notification End
                return response()->json(['status' => 'success', 'msg' => 'Leads successfully assigned']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'faild', 'msg' => $e->getMessage()]);
        }
    }
    public function leadDelete(Request $request)
    {
        try {
            Lead::find($request->lead_id)->delete();
            return response()->json(['status' => 'success', 'msg' => 'Lead Successfully Deleted.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed', 'msg' => $e->getMessage()]);
        }
    }
}
