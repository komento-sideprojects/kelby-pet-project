import { useState, useEffect } from 'react';
import api from '../api/axios';
import { BookUp, User, Calendar, Loader2, AlertCircle } from 'lucide-react';

export default function IssuedBooks() {
    const [issued, setIssued] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // We'll need to create this endpoint in AdminController
        api.get('/admin/issued-books')
            .then(res => setIssued(res.data))
            .catch(console.error)
            .finally(() => setLoading(false));
    }, []);

    if (loading) return (
        <div className="flex justify-center items-center h-64">
            <Loader2 className="animate-spin text-indigo-500" size={48} />
        </div>
    );

    return (
        <div className="space-y-8">
            <div className="glass-card rounded-[32px] overflow-hidden">
                <table className="w-full text-left border-collapse">
                    <thead className="bg-slate-50/50">
                        <tr>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Book</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Student</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Issue Date</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Due Date</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100">
                        {issued.map((record) => (
                            <tr key={record.id} className="hover:bg-slate-50/30 transition-all">
                                <td className="p-6">
                                    <div className="flex items-center gap-4">
                                        <div className="p-3 rounded-xl bg-pink-50 text-pink-600">
                                            <BookUp size={24} />
                                        </div>
                                        <h4 className="font-bold text-slate-800">{record.book.title}</h4>
                                    </div>
                                </td>
                                <td className="p-6">
                                    <div className="flex items-center gap-3 text-slate-600 font-medium">
                                        <User size={18} className="text-slate-400" />
                                        {record.user.name}
                                    </div>
                                </td>
                                <td className="p-6">
                                    <div className="flex items-center gap-3 text-slate-500 text-sm">
                                        <Calendar size={18} className="text-slate-400" />
                                        {record.borrow_date}
                                    </div>
                                </td>
                                <td className="p-6 text-slate-500 text-sm font-bold">
                                    {record.due_date}
                                </td>
                                <td className="p-6">
                                    <span className={`px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest ${record.status === 'borrowed' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600'
                                        }`}>
                                        {record.status}
                                    </span>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                {issued.length === 0 && (
                    <div className="text-center py-20 bg-white rounded-[32px]">
                        <AlertCircle className="mx-auto text-slate-200 mb-4" size={64} />
                        <h3 className="text-2xl font-bold text-slate-300">No books are currently issued</h3>
                    </div>
                )}
            </div>
        </div>
    );
}
