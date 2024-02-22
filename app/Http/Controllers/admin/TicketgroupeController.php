<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\admin\TicketgroupeResource;
use App\Http\Resources\admin\TicketResource;
use App\Models\Ticket;
use App\Models\Ticketgroupe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketgroupeController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasPermissionTo('index tickets')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $ticketgroupData = TicketgroupeResource::collection(Ticketgroupe::latest()->paginate(10));
        return Inertia::render('Ticketgroupe/Index', compact('ticketgroupData'));
    }

    public function GetTicketData(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('index tickets')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $result = Ticketgroupe::query();
        if ($request->input('search')) {
            $result = $result->where('title', 'LIKE', "%$request->search%");
        }
        return TicketgroupeResource::collection($result->latest()->paginate(10))->resource;
    }

    public function showTicketGroupe(Ticketgroupe $ticketgroupe)
    {
        if (!auth()->user()->hasPermissionTo('show ticketgroupe')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $ticketgroupeId = $ticketgroupe->id;
        $ticketData = TicketResource::collection(Ticket::where('ticketgroupe_id', $ticketgroupeId)->get());
        return Inertia::render('Ticketgroupe/ShowTicketChat', compact('ticketData'));
    }

    public function showTicketGroupeData(Ticketgroupe $ticketgroupe)
    {
        if (!auth()->user()->hasPermissionTo('show ticketgroupe')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $ticketgroupeId = $ticketgroupe->id;
        return TicketResource::collection(Ticket::where('ticketgroupe_id', $ticketgroupeId)->get());
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'ticketgroupe_id' => 'required',
            'user_id' => 'required',
            'body' => 'required',
        ]);
        $ticketgroupe = Ticketgroupe::where('id', $request->ticketgroupe_id)->first();
        $ticket = Ticket::create([
            'ticketgroupe_id' => $request->ticketgroupe_id,
            'user_id' => $request->user_id,
            'body' => $request->body,
        ]);
        if ($ticket != '') {
            $ticketgroupe->update([
                'status' => 1,
            ]);
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }

    public function destroy(string $id)
    {
        if (!auth()->user()->hasPermissionTo('delete ticket')) {
//            return redirect()->route('admin.index')->with('error', 'شما به این بخض دسترسی ندارید');
            abort(404);
        }
        $ticketgroupe = Ticketgroupe::where('id', $id)->first();
        $check = $ticketgroupe->delete();
        if ($check) {
            $ticketgroupe->tickets()->delete();
            return response()->json(200);
        } else {
            return response()->json(100);
        }
    }
}
