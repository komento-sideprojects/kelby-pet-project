import { useState, useEffect } from 'react';
import api from '../api/axios';
import { Users, Mail, UserPlus, Loader2, MoreVertical } from 'lucide-react';

export default function StudentsList() {
    const [students, setStudents] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        api.get('/admin/students')
            .then(res => setStudents(res.data))
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
            <div className="flex justify-end">
                <button className="flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all">
                    <UserPlus size={20} />
                    Add Student
                </button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {students.map((student) => (
                    <div key={student.id} className="glass-card p-8 rounded-[32px] hover:-translate-y-2 transition-all duration-300">
                        <div className="flex justify-between items-start mb-6">
                            <div className="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-500 flex items-center justify-center text-white text-2xl font-black">
                                {student.name[0].toUpperCase()}
                            </div>
                            <button className="p-2 text-slate-400 hover:text-slate-600 transition-all">
                                <MoreVertical size={24} />
                            </button>
                        </div>

                        <h3 className="text-xl font-bold text-slate-800 mb-1">{student.name}</h3>
                        <div className="flex items-center gap-2 text-slate-400 mb-6">
                            <Mail size={16} />
                            <span className="text-sm font-medium">{student.email}</span>
                        </div>

                        <div className="pt-6 border-t border-slate-100 flex justify-between items-center text-sm font-bold">
                            <span className="text-slate-400">Status</span>
                            <span className="text-emerald-500">Active</span>
                        </div>
                    </div>
                ))}
            </div>

            {students.length === 0 && (
                <div className="text-center py-20 bg-white rounded-[32px] border-2 border-dashed border-slate-100">
                    <Users className="mx-auto text-slate-200 mb-4" size={64} />
                    <h3 className="text-2xl font-bold text-slate-300">No students registered yet</h3>
                </div>
            )}
        </div>
    );
}
