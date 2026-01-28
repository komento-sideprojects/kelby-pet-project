import { useState } from 'react';
import { useNavigate, Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { Library, Eye, EyeOff, Loader2 } from 'lucide-react';

export default function Login() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');
    const { login } = useAuth();
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        setError('');
        try {
            const data = await login(email, password);
            if (data.user.role === 'admin') {
                navigate('/admin');
            } else {
                navigate('/dashboard');
            }
        } catch (err) {
            setError(err.response?.data?.message || 'Failed to login');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="min-h-screen flex items-center justify-center relative p-4">
            <div className="shape shape-1" style={{ top: '20%', left: '20%' }}></div>
            <div className="shape shape-2" style={{ bottom: '20%', right: '20%' }}></div>

            <div className="glass-card w-full max-auto max-w-[450px] p-12 rounded-[24px]">
                <header className="text-center mb-10">
                    <div className="inline-block mb-4 p-3 rounded-2xl bg-gradient-to-br from-indigo-500 to-pink-500 text-white">
                        <Library size={48} />
                    </div>
                    <h1 className="text-3xl font-bold mb-2">Welcome Back</h1>
                    <p className="text-slate-500">Enter your credentials to access the portal.</p>
                </header>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="text-left">
                        <label className="block text-sm font-medium mb-2">Email Address</label>
                        <input
                            type="email"
                            className="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all"
                            placeholder="library@example.com"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </div>

                    <div className="text-left">
                        <label className="block text-sm font-medium mb-2">Password</label>
                        <div className="relative">
                            <input
                                type={showPassword ? "text" : "password"}
                                className="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all"
                                placeholder="••••••••"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                            />
                            <button
                                type="button"
                                onClick={() => setShowPassword(!showPassword)}
                                className="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-500"
                            >
                                {showPassword ? <EyeOff size={20} /> : <Eye size={20} />}
                            </button>
                        </div>
                    </div>

                    {error && <p className="text-red-500 text-sm">{error}</p>}

                    <button
                        disabled={loading}
                        className="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2"
                    >
                        {loading && <Loader2 className="animate-spin" size={20} />}
                        Sign In
                    </button>

                    <Link to="/register" className="block w-full text-center py-4 bg-transparent border-2 border-indigo-100 text-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition-all mt-4">
                        Sign Up
                    </Link>
                </form>
            </div>
        </div>
    );
}
