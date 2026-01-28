import { useState, useEffect } from 'react';
import api from '../api/axios';
import { ShoppingCart, BookCheck, AlertCircle, Loader2 } from 'lucide-react';

export default function BrowseBooks() {
    const [books, setBooks] = useState([]);
    const [loading, setLoading] = useState(true);
    const [borrowingId, setBorrowingId] = useState(null);
    const [msg, setMsg] = useState(null);

    useEffect(() => {
        fetchBooks();
    }, []);

    const fetchBooks = async () => {
        try {
            const res = await api.get('/books/browse');
            setBooks(res.data);
        } catch (err) {
            console.error(err);
        } finally {
            setLoading(false);
        }
    };

    const handleBorrow = async (bookId) => {
        setBorrowingId(bookId);
        setMsg(null);
        try {
            const res = await api.post('/books/borrow', { book_id: bookId });
            setMsg({ type: 'success', text: res.data.message });
            fetchBooks();
        } catch (err) {
            setMsg({ type: 'error', text: err.response?.data?.message || 'Failed to borrow' });
        } finally {
            setBorrowingId(null);
        }
    };

    if (loading) return (
        <div className="flex justify-center items-center h-64">
            <Loader2 className="animate-spin text-indigo-500" size={48} />
        </div>
    );

    return (
        <div className="space-y-8">
            {msg && (
                <div className={`p-4 rounded-xl flex items-center gap-3 ${msg.type === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'}`}>
                    {msg.type === 'success' ? <BookCheck size={20} /> : <AlertCircle size={20} />}
                    <span className="font-semibold">{msg.text}</span>
                </div>
            )}

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                {books.map((book) => (
                    <div key={book.id} className="glass-card p-6 rounded-3xl group hover:-translate-y-2 transition-all duration-300 flex flex-col h-full">
                        <div className="flex justify-between items-start mb-4">
                            <span className="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-lg uppercase tracking-wider">
                                {book.category}
                            </span>
                            <span className={`text-xs font-bold ${book.available > 0 ? 'text-emerald-500' : 'text-red-400'}`}>
                                {book.available > 0 ? 'Available' : 'Out of Stock'}
                            </span>
                        </div>

                        <div className="flex-1">
                            <h3 className="font-bold text-xl text-slate-800 mb-1 group-hover:text-indigo-600 transition-all">
                                {book.title}
                            </h3>
                            <p className="text-slate-500 text-sm mb-6">by {book.author}</p>
                        </div>

                        <button
                            disabled={book.available === 0 || borrowingId === book.id}
                            onClick={() => handleBorrow(book.id)}
                            className={`w-full py-3 rounded-2xl font-bold flex items-center justify-center gap-2 transition-all ${book.available > 0
                                    ? 'bg-slate-900 text-white hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-100'
                                    : 'bg-slate-100 text-slate-400 cursor-not-allowed'
                                }`}
                        >
                            {borrowingId === book.id ? <Loader2 className="animate-spin" size={20} /> : <ShoppingCart size={20} />}
                            {book.available > 0 ? 'Borrow Now' : 'Unavailable'}
                        </button>
                    </div>
                ))}
            </div>

            {books.length === 0 && (
                <div className="text-center py-20 bg-white rounded-[32px] border-2 border-dashed border-slate-100">
                    <AlertCircle className="mx-auto text-slate-200 mb-4" size={64} />
                    <h3 className="text-2xl font-bold text-slate-300">No books found</h3>
                </div>
            )}
        </div>
    );
}
