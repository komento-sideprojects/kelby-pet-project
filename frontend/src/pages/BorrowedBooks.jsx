import { useState, useEffect } from 'react';
import api from '../api/axios';
import { Clock, Calendar, Bookmark, Loader2, AlertCircle } from 'lucide-react';

export default function BorrowedBooks() {
    const [borrowed, setBorrowed] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        api.get('/books/borrowed')
            .then(res => setBorrowed(res.data))
            .catch(console.error)
            .finally(() => setLoading(false));
    }, []);

    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    };

    if (loading) return (
        <div className="flex justify-center items-center h-64">
            <Loader2 className="animate-spin text-indigo-500" size={48} />
        </div>
    );

    return (
        <div className="glass-card rounded-[32px] overflow-hidden">
            <div className="overflow-x-auto">
                <table className="w-full text-left border-collapse">
                    <thead>
                        <tr className="bg-slate-50/50">
                            <th className="px-8 py-6 font-bold text-slate-800 text-sm">Book</th>
                            <th className="px-8 py-6 font-bold text-slate-800 text-sm">Category</th>
                            <th className="px-8 py-6 font-bold text-slate-800 text-sm">Borrowed</th>
                            <th className="px-8 py-6 font-bold text-slate-800 text-sm">Due Date</th>
                            <th className="px-8 py-6 font-bold text-slate-800 text-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {borrowed.map((item) => {
                            const dueDate = new Date(item.due_date);
                            const isOverdue = new Date() > dueDate && item.status === 'borrowed';

                            return (
                                <tr key={item.id} className="border-t border-slate-100 hover:bg-slate-50/30 transition-all">
                                    <td className="px-8 py-6">
                                        <div className="flex items-center gap-4">
                                            <div className="p-3 rounded-2xl bg-indigo-50 text-indigo-500">
                                                <Bookmark size={20} />
                                            </div>
                                            <div>
                                                <h4 className="font-bold text-slate-800">{item.book.title}</h4>
                                                <p className="text-xs text-slate-500 font-medium">{item.book.author}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td className="px-8 py-6">
                                        <span className="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-lg">
                                            {item.book.category}
                                        </span>
                                    </td>
                                    <td className="px-8 py-6 text-sm text-slate-500 font-medium">
                                        {formatDate(item.borrow_date)}
                                    </td>
                                    <td className="px-8 py-6 text-sm text-slate-500 font-medium">
                                        {formatDate(item.due_date)}
                                    </td>
                                    <td className="px-8 py-6">
                                        {isOverdue ? (
                                            <span className="px-4 py-2 bg-red-50 text-red-600 text-xs font-bold rounded-xl flex items-center gap-2 w-fit">
                                                <AlertCircle size={14} /> Overdue
                                            </span>
                                        ) : (
                                            <span className="px-4 py-2 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-xl flex items-center gap-2 w-fit">
                                                <Clock size={14} /> Active
                                            </span>
                                        )}
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </div>

            {borrowed.length === 0 && (
                <div className="text-center py-20">
                    <History className="mx-auto text-slate-200 mb-4" size={64} />
                    <h3 className="text-2xl font-bold text-slate-400">No borrowing history</h3>
                </div>
            )}
        </div>
    );
}
