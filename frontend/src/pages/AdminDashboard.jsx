import { useState, useEffect } from 'react';
import api from '../api/axios';
import { Users, BookCopy, MoveUp, Loader2 } from 'lucide-react';

export default function AdminDashboard() {
    const [stats, setStats] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        api.get('/admin/dashboard')
            .then(res => setStats(res.data))
            .catch(console.error)
            .finally(() => setLoading(false));
    }, []);

    if (loading) return (
        <div className="flex justify-center items-center h-64">
            <Loader2 className="animate-spin text-indigo-500" size={48} />
        </div>
    );

    const cards = [
        { label: 'Total Books', value: stats.totalBooks, icon: BookCopy, color: 'bg-indigo-500' },
        { label: 'Total Students', value: stats.totalUsers, icon: Users, color: 'bg-pink-500' },
        { label: 'Books Issued', value: stats.totalBorrowed, icon: MoveUp, color: 'bg-emerald-500' },
    ];

    return (
        <div className="space-y-10">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                {cards.map((card, i) => (
                    <div
                        key={i}
                        onClick={() => alert(`View details for ${card.label}`)}
                        className="glass-card p-8 rounded-[32px] flex items-center gap-6 cursor-pointer hover:scale-105 transition-all duration-300 active:scale-95"
                    >
                        <div className={`p-5 rounded-3xl ${card.color} text-white shadow-xl shadow-slate-100`}>
                            <card.icon size={32} />
                        </div>
                        <div>
                            <p className="text-slate-500 font-bold text-sm uppercase tracking-wider mb-1">{card.label}</p>
                            <h3 className="text-4xl font-black text-slate-800">{card.value}</h3>
                        </div>
                    </div>
                ))}
            </div>

            <div className="glass-card p-12 rounded-[40px] text-center bg-white/40">
                <h3 className="text-2xl font-bold text-slate-800 mb-2">Recent System Activity</h3>
                <p className="text-slate-500">Real-time logs and updates will appear here.</p>
            </div>
        </div>
    );
}
