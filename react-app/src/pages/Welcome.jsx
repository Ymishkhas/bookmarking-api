import { BookmarkIcon } from '@heroicons/react/16/solid';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';

const Welcome = () => {

    const { login } = useAuth();
    const navigate = useNavigate();

    async function handleLogin() {
        try {
            await login();
            navigate('/');
        } catch (error) {
            console.log('Failed to login: ', error);
        }
    }

    return (
        <div id="landing-container">
            <h1 id="title"><BookmarkIcon id="title-icon"/>One place to hold all your bookmarks</h1>
            <h3 id="sub-title">Join and access your bookmarks from any device</h3>
            <button id="sign-in-button" onClick={handleLogin}>Enter Bookmarking</button>
        </div>
    )
}

export default Welcome;