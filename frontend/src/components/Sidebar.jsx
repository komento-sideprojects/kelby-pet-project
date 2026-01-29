import { useNavigate, NavLink } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import {
    LayoutDashboard,
    Search,
    BookOpen,
    Settings,
    LogOut,
    Library,
    UserCircle
} from 'lucide-react';

export default function Sidebar() {
    const { user, logout } = useAuth();
    const navigate = useNavigate();

    const handleLogout = async () => {
        await logout();
        navigate('/login');
    };

    const getInitials = (name) => {
        return name ? name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2) : '??';
    };

    const isAdmin = user?.role === 'admin';

    const links = isAdmin ? [
        { to: '/admin', icon: LayoutDashboard, label: 'Dashboard' },
        { to: '/admin/books', icon: Search, label: 'Manage Books' },
        { to: '/admin/issued', icon: BookOpen, label: 'Issued Books' },
        { to: '/admin/students', icon: UserCircle, label: 'Students' },
    ] : [
        { to: '/dashboard', icon: LayoutDashboard, label: 'Home' },
        { to: '/browse', icon: Search, label: 'Browse Books' },
        { to: '/borrowed', icon: BookOpen, label: 'My Books' },
    ];

    return (
        <aside className="w-72 h-screen glass-card flex flex-col p-6 sticky top-0">
            <div className="flex items-center gap-3 mb-10 pl-2">
                <div className="p-2 rounded-xl bg-indigo-600 text-white">
                    <Library size={24} />
                </div>
                <span className="font-bold text-xl tracking-tight">
                    {isAdmin ? 'LMS Admin' : 'LMS Student'}
                </span>
            </div>

            <nav className="flex-1 space-y-2">
                {links.map((link) => (
                    <NavLink
                        key={link.to}
                        to={link.to}
                        end={link.to === '/admin' || link.to === '/dashboard'}
                        className={({ isActive }) =>
                            `flex items-center gap-3 px-4 py-3 rounded-xl transition-all ${isActive
                                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200'
                                : 'text-slate-600 hover:bg-slate-100'
                            }`
                        }
                    >
                        <link.icon size={20} />
                        <span className="font-medium">{link.label}</span>
                    </NavLink>
                ))}
            </nav>

            <div className="mt-auto pt-6 border-t border-slate-100 flex flex-col gap-2">
                <button
                    onClick={() => alert('Settings coming soon!')}
                    className="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition-all"
                >
                    <Settings size={20} />
                    <span className="font-medium">Settings</span>
                </button>
                <button
                    onClick={handleLogout}
                    className="flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all"
                >
                    <LogOut size={20} />
                    <span className="font-medium">Logout</span>
                </button>
            </div>

            <div className="mt-6 p-4 rounded-2xl bg-slate-50 flex items-center gap-3">
                <div className={`w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm ${isAdmin ? 'bg-slate-800' : 'bg-gradient-to-br from-emerald-500 to-blue-500'}`}>
                    {getInitials(user?.name)}
                </div>
                <div className="overflow-hidden">
                    <h4 className="font-bold text-sm truncate">{user?.name}</h4>
                    <p className="text-xs text-slate-500 truncate">{user?.email}</p>
                </div>
            </div>
        </aside>
    );
}
