import { useState, useEffect } from 'react';
import api from '../api/axios';
import { Book as BookIcon, CheckCircle2, History, Loader2 } from 'lucide-react';

export default function StudentDashboard() {
    return (
        <div className="glass-card p-12 rounded-[24px] text-center max-w-2xl mx-auto mt-10">
            <div className="inline-block p-6 rounded-3xl bg-indigo-50 text-indigo-600 mb-6">
                <BookIcon size={48} />
            </div>
            <h2 className="text-3xl font-bold mb-4 text-slate-800">Welcome to Library Catalog</h2>
            <p className="text-lg text-slate-500 mb-8 leading-relaxed">
                Discover a world of knowledge. Browse our extensive collection of books, manage your borrowings, and expand your horizons.
            </p>
            <div className="flex gap-4 justify-center">
                <button
                    onClick={() => window.location.href = '/browse'}
                    className="px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all"
                >
                    Browse Books
                </button>
            </div>
        </div>
    );
}
