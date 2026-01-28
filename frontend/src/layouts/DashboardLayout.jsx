import { Outlet } from 'react-router-dom';
import Sidebar from '../components/Sidebar';

export default function DashboardLayout({ title, subtitle }) {
    return (
        <div className="flex bg-slate-50 min-h-screen">
            <Sidebar />
            <main className="flex-1 p-10 overflow-auto">
                <header className="flex justify-between items-center mb-10">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-800">{title}</h1>
                        <p className="text-slate-500 mt-1">{subtitle}</p>
                    </div>
                    <div className="flex gap-4">
                        <button className="p-3 glass-card rounded-xl text-slate-500 hover:text-indigo-600 transition-all">
                            <i className="ph-bold ph-bell text-xl"></i>
                        </button>
                        <button className="p-3 glass-card rounded-xl text-slate-500 hover:text-indigo-600 transition-all">
                            <i className="ph-bold ph-magnifying-glass text-xl"></i>
                        </button>
                    </div>
                </header>

                <div className="content-area">
                    <Outlet />
                </div>
            </main>
        </div>
    );
}
