import { useState, useEffect } from 'react';
import api from '../api/axios';
import { Search, Plus, Edit, Trash2, Loader2, BookOpen, X } from 'lucide-react';

export default function ManageBooks() {
    const [books, setBooks] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [showModal, setShowModal] = useState(false);
    const [submitting, setSubmitting] = useState(false);
    const [formData, setFormData] = useState({
        title: '',
        author: '',
        category: 'Fiction',
        quantity: 1
    });

    useEffect(() => {
        fetchBooks();
    }, []);

    const fetchBooks = async () => {
        try {
            const res = await api.get('/admin/books');
            setBooks(res.data);
        } catch (err) {
            console.error(err);
        } finally {
            setLoading(false);
        }
    };

    const handleAddBook = async (e) => {
        e.preventDefault();
        setSubmitting(true);
        try {
            await api.post('/admin/books', formData);
            setShowModal(false);
            setFormData({ title: '', author: '', category: 'Fiction', quantity: 1 });
            fetchBooks();
            alert('Book added successfully!');
        } catch (err) {
            alert(err.response?.data?.message || 'Failed to add book');
        } finally {
            setSubmitting(false);
        }
    };

    const filteredBooks = books.filter(book =>
        book.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
        book.author.toLowerCase().includes(searchTerm.toLowerCase())
    );

    if (loading) return (
        <div className="flex justify-center items-center h-64">
            <Loader2 className="animate-spin text-indigo-500" size={48} />
        </div>
    );

    return (
        <div className="space-y-8">
            <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div className="relative w-full md:w-96">
                    <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" size={20} />
                    <input
                        type="text"
                        placeholder="Search books or authors..."
                        className="w-full pl-12 pr-4 py-3 glass-card rounded-2xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                    />
                </div>
                <button
                    onClick={() => setShowModal(true)}
                    className="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all"
                >
                    <Plus size={20} />
                    Add New Book
                </button>
            </div>

            <div className="glass-card rounded-[32px] overflow-hidden">
                <table className="w-full text-left border-collapse">
                    <thead className="bg-slate-50/50">
                        <tr>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Book Details</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Author</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Stock</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider">Category</th>
                            <th className="p-6 font-bold text-slate-500 text-sm uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100">
                        {filteredBooks.map((book) => (
                            <tr key={book.id} className="hover:bg-slate-50/30 transition-all">
                                <td className="p-6">
                                    <div className="flex items-center gap-4">
                                        <div className="p-3 rounded-xl bg-indigo-50 text-indigo-600">
                                            <BookOpen size={24} />
                                        </div>
                                        <div>
                                            <h4 className="font-bold text-slate-800">{book.title}</h4>
                                            <p className="text-sm text-slate-400">ID: #{book.id}</p>
                                        </div>
                                    </div>
                                </td>
                                <td className="p-6 text-slate-600 font-medium">{book.author}</td>
                                <td className="p-6">
                                    <div className="flex items-center gap-2">
                                        <span className={`w-2 h-2 rounded-full ${book.available > 5 ? 'bg-emerald-500' : book.available > 0 ? 'bg-amber-500' : 'bg-red-500'}`}></span>
                                        <span className="font-bold text-slate-700">{book.available} / {book.quantity}</span>
                                    </div>
                                </td>
                                <td className="p-6">
                                    <span className="px-3 py-1 bg-slate-100 text-slate-500 text-xs font-bold rounded-lg uppercase tracking-wider">
                                        {book.category}
                                    </span>
                                </td>
                                <td className="p-6">
                                    <div className="flex justify-end gap-2">
                                        <button
                                            onClick={() => alert(`Edit book: ${book.title}`)}
                                            className="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                        >
                                            <Edit size={20} />
                                        </button>
                                        <button
                                            onClick={() => alert(`Delete book: ${book.title}`)}
                                            className="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                        >
                                            <Trash2 size={20} />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                {filteredBooks.length === 0 && (
                    <div className="text-center py-20 text-slate-400">
                        No books found matching your search.
                    </div>
                )}
            </div>

            {/* Modal */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={() => setShowModal(false)}></div>
                    <div className="relative glass-card w-full max-w-lg p-8 rounded-[32px] animate-in fade-in zoom-in duration-300">
                        <div className="flex justify-between items-center mb-6">
                            <h3 className="text-2xl font-bold text-slate-800">Add New Book</h3>
                            <button onClick={() => setShowModal(false)} className="p-2 hover:bg-slate-100 rounded-xl">
                                <X size={24} className="text-slate-400" />
                            </button>
                        </div>

                        <form onSubmit={handleAddBook} className="space-y-4">
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-1">Book Title</label>
                                <input
                                    type="text"
                                    required
                                    className="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all"
                                    placeholder="e.g. The Great Gatsby"
                                    value={formData.title}
                                    onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-bold text-slate-700 mb-1">Author</label>
                                <input
                                    type="text"
                                    required
                                    className="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all"
                                    placeholder="e.g. F. Scott Fitzgerald"
                                    value={formData.author}
                                    onChange={(e) => setFormData({ ...formData, author: e.target.value })}
                                />
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="block text-sm font-bold text-slate-700 mb-1">Category</label>
                                    <select
                                        className="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all bg-white"
                                        value={formData.category}
                                        onChange={(e) => setFormData({ ...formData, category: e.target.value })}
                                    >
                                        <option value="Fiction">Fiction</option>
                                        <option value="Non-Fiction">Non-Fiction</option>
                                        <option value="Science">Science</option>
                                        <option value="Technology">Technology</option>
                                        <option value="History">History</option>
                                    </select>
                                </div>
                                <div>
                                    <label className="block text-sm font-bold text-slate-700 mb-1">Quantity</label>
                                    <input
                                        type="number"
                                        min="1"
                                        required
                                        className="w-full px-4 py-3 rounded-xl border-2 border-slate-100 focus:border-indigo-500 outline-none transition-all"
                                        value={formData.quantity}
                                        onChange={(e) => setFormData({ ...formData, quantity: e.target.value })}
                                    />
                                </div>
                            </div>
                            <button
                                type="submit"
                                disabled={submitting}
                                className="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 mt-4"
                            >
                                {submitting ? <Loader2 className="animate-spin" /> : <Plus size={20} />}
                                Confirm Add Book
                            </button>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
}
