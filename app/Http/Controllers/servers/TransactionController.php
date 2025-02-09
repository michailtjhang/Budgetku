<?php

namespace App\Http\Controllers\servers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi user.
     */
    public function index()
    {
        $expenses = Transaction::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->with('category')->paginate(3);
        $income = Transaction::where('user_id', Auth::id())
            ->where('type', 'income')
            ->with('category')->paginate(3);

        $categories = Category::all(); // Fetch all categories
        return view('servers.transactions.index', [
            'expenses' => $expenses,
            'income' => $income,
            'categories' => $categories,
            'page_title' => 'Transactions',
        ]);
    }

    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'type' => 'required|in:income,expense',
        ]);

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'date' => $validated['date'],
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'type' => $validated['type'],
        ]);

        return back()->with('success', 'Transaction created successfully.');
    }

    /**
     * Menampilkan detail transaksi.
     */
    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('id', $id)->with('category')->firstOrFail();
        return response()->json($transaction);
    }

    /**
     * Mengupdate transaksi.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('id', $id)->firstOrFail();

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'type' => 'required|in:income,expense',
        ]);

        $transaction->update($validated);

        return back()->with('success', 'Transaction updated successfully.');
    }

    /**
     * Menghapus transaksi.
     */
    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('id', $id)->firstOrFail();
        $transaction->delete();

        return back()->with('success', 'Transaction deleted successfully.');
    }
}
