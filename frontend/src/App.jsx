import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { AuthProvider, useAuth } from './context/AuthContext';
import Login from './pages/Login';
import Register from './pages/Register';
import DashboardLayout from './layouts/DashboardLayout';
import StudentDashboard from './pages/StudentDashboard';
import BrowseBooks from './pages/BrowseBooks';
import BorrowedBooks from './pages/BorrowedBooks';
import AdminDashboard from './pages/AdminDashboard';

const ProtectedRoute = ({ children, role }) => {
  const { user, loading } = useAuth();

  if (loading) return (
    <div className="flex justify-center items-center h-screen bg-slate-50">
      <div className="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500"></div>
    </div>
  );

  if (!user) return <Navigate to="/login" />;
  if (role && user.role !== role) return <Navigate to={user.role === 'admin' ? '/admin' : '/dashboard'} />;

  return children;
};

function App() {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />

          {/* Student Routes */}
          <Route element={<ProtectedRoute role="user"><DashboardLayout title="Student Portal" subtitle="Welcome back to your library." /></ProtectedRoute>}>
            <Route path="/dashboard" element={<StudentDashboard />} />
            <Route path="/browse" element={<BrowseBooks />} />
            <Route path="/borrowed" element={<BorrowedBooks />} />
          </Route>

          {/* Admin Routes */}
          <Route element={<ProtectedRoute role="admin"><DashboardLayout title="Admin Console" subtitle="System overview and management." /></ProtectedRoute>}>
            <Route path="/admin" element={<AdminDashboard />} />
            {/* Add more admin pages like book management here */}
          </Route>

          <Route path="/" element={<Navigate to="/login" />} />
        </Routes>
      </Router>
    </AuthProvider>
  );
}

export default App;
