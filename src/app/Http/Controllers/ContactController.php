<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactsExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ContactController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        $gender = $request->input('gender');
        DB::enableQueryLog();
        $gender = $gender !== 'all' ? (int)$gender : null;
        // dd($request);
        // dd($request->input('gender') );
        $contacts = Contact::query()
            // ->when($request->input('name'), function ($query, $name) {
            //     $normalized_name = str_replace(' ', '', $name);
            //     return $query->where(function ($query) use ($normalized_name) {
            //         $query->where(function ($query) use ($normalized_name) {
            //             $query->whereRaw("REPLACE(CONCAT(first_name, ' ', last_name), ' ', '') LIKE ?", ["%$normalized_name%"])
            //                 ->orWhereRaw("REPLACE(CONCAT(last_name, ' ', first_name), ' ', '') LIKE ?", ["%$normalized_name%"]);
            //         })
            //         ->orWhere(function ($query) use ($normalized_name) {
            //             $query->whereRaw("REPLACE(email, ' ', '') LIKE ?", ["%$normalized_name%"]);
            //         });
            //     });
            // })
            ->when($gender !== null, function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })
            // ->when($gender && $gender !== 'all', function ($query, $gender) {
            //     $gender = (int) $gender; // 明示的にキャスト
            //     return $query->where('gender', $gender);
            // })
            // ->when($request->input('date'), function ($query, $date) {
            //     $formatted_date = Carbon::parse($date)->format('Y-m-d');
            //     return $query->whereDate('updated_at', $formatted_date);
            // })
            ->paginate(7);

        $queryLog = DB::getQueryLog();
        // dd($queryLog);  // クエリログをデバッグする
        return view('contacts/index', compact('contacts'));
    }


    public function exportCsv(Request $request)
    {
        // dd($request->all());
        $contacts = $this->getFilteredContacts($request);

        $response = new StreamedResponse(function () use ($contacts) {
            $handle = fopen('php://output', 'w');

            // CSVのヘッダーを出力
            fputcsv($handle, [
                'First Name',
                'Last Name',
                'Gender',
                'Email',
                'Telephone',
                'Address',
                'Building',
                'Category ID',
                'Detail',
                'Updated At',
            ]);

            // データ行を出力
            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->first_name,
                    $contact->last_name,
                    $contact->gender,
                    $contact->email,
                    $contact->tell,
                    $contact->address,
                    $contact->building,
                    $contact->category_id,
                    $contact->detail,
                    $contact->updated_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        // レスポンスヘッダーの設定
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="contacts.csv"');

        return $response;
    }


    // public function exportExcel(Request $request)
    // {
    //     $contacts = $this->getFilteredContacts($request);

    //     return Excel::download(new ContactsExport($contacts), 'contacts.xlsx');
    // }

    private function getFilteredContacts(Request $request)
    {
        $gender = $request->input('gender');
        $gender = $gender !== 'all' ? (int)$gender : null;

        return Contact::query()
            ->when($request->input('name'), function ($query, $name) {
                $normalized_name = str_replace(' ', '', $name);
                return $query->where(function ($query) use ($normalized_name) {
                    $query->whereRaw("REPLACE(CONCAT(first_name, ' ', last_name), ' ', '') LIKE ?", ["%$normalized_name%"])
                        ->orWhereRaw("REPLACE(CONCAT(last_name, ' ', first_name), ' ', '') LIKE ?", ["%$normalized_name%"]);
                });
            })
            ->when($gender !== null, function ($query) use ($gender) {
                return $query->where('gender', $gender);
            })
            ->when($request->input('date'), function ($query, $date) {
                $formatted_date = Carbon::parse($date)->format('Y-m-d');
                return $query->whereDate('updated_at', $formatted_date);
            })
            ->get();
    }

    public function showDetail($id)
    {
        $contact = Contact::find($id);
        // dd($contact);

        if (!$contact) {
            return response('Contact not found', 404);
        }

        return view('partials.contact_detail', compact('contact'));
    }




    // return $query->whereRaw(
    //     "REPLACE(CONCAT(first_name, ' ', last_name), ' ', '') = ?", 
    //     [$normalized_name]
    // )
    // ->orWhereRaw(
    //     "REPLACE(CONCAT(last_name, ' ', first_name), ' ', '') = ?", 
    //     [$normalized_name]
    // );

    // public function index()
    // {
    //     $contacts = Contact::all(); // contacts テーブルの全レコードを取得
    //     return view('contacts/index', compact('contacts')); // contacts 変数をビューに渡す
    // }
}
