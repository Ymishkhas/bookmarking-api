import { useEffect, useState } from "react";
import { useAuth } from '../contexts/AuthContext';
import { createBookMark, readAllBookMarks, updateBookMark, deleteBookMark } from "../services/api";
import Card from "../components/Card";

const Home = () => {

    const [bookmarks, setBookmarks] = useState([]);
    const [filteredBookmarks, setFilteredBookmarks] = useState([]);
    const [mostClicked, setMostClicked] = useState([]);
    const [titleInput, setTitleInput] = useState("");
    const [urlInput, setUrlInput] = useState("");
    const [filterInput, setFilterInput] = useState("");


    const { user } = useAuth();

    const fetchBookmarks = async () => {
        try {
            if (user) {
                const result = await readAllBookMarks(user.uid);
                setBookmarks(result);
            }
        } catch (error) {
            console.log("Error fetching in home: ", error)
        }
    }
    useEffect(() => {
        fetchBookmarks();
    }, [])

    const handleCreateBookMark = async () => {
        try {
            if (user && urlInput.length != 0) {
                const result = await createBookMark({
                    user_id: user.uid,
                    title: titleInput,
                    url: urlInput
                });
            }
            fetchBookmarks();
            setTitleInput("");
            setUrlInput("");
        } catch (error) {
            console.log(error)
        }
    }

    const handleUpdateBookMark = async (id, title, url) => {
        try {
            if (user && url.length != 0) {
                const result = await updateBookMark({
                    id: id,
                    user_id: user.uid,
                    title: title,
                    url: url
                });
            }
            fetchBookmarks();
        } catch (error) {
            console.log(error)
        }
    }

    const handleDeleteBookMark = async (id) => {
        try {
            if (user) {
                const result = await deleteBookMark({
                    id: id,
                    user_id: user.uid
                });
                console.log(result)
            }
            fetchBookmarks();
        } catch (error) {
            console.log(error)
        }
    }

    const filterBookMarks = (filter) => {

        if (filter === "") {
            setFilteredBookmarks([]);
            return;
        }

        const filtered = bookmarks.filter((bookmark) => {
            return bookmark.title.toLowerCase().includes(filter) || bookmark.url.toLowerCase().includes(filter);
        })

        console.log(filtered)

        setFilteredBookmarks(filtered);
    }

    return (
        <div id="home-container">
            <div id="newbookmark-container">
                <input className="new-input" type="text" placeholder="Title" value={titleInput} onChange={(e) => setTitleInput(e.target.value)} />
                <input className="new-input" type="text" placeholder="URL" value={urlInput} onChange={(e) => setUrlInput(e.target.value)} required />
                <button id="create-button" onClick={() => handleCreateBookMark()}>Create Bookmark</button>
            </div>
            <div id="filter">
                <input id="search-input" type="text" placeholder="Search bookmarks..." onChange={(e) => filterBookMarks(e.target.value)} />
            </div>
            <div id="bookmarks-container">
                {filteredBookmarks.length > 0 ? (
                    filteredBookmarks.map(bookmark => (
                        <Card
                            key={bookmark.id}
                            id={bookmark.id}
                            title={bookmark.title}
                            url={bookmark.url}
                            date_added={bookmark.date_added}
                            handleUpdateBookMark={handleUpdateBookMark}
                            handleDeleteBookMark={handleDeleteBookMark}
                        />
                    ))
                ) : (
                    bookmarks.map(bookmark => (
                        <Card
                            key={bookmark.id}
                            id={bookmark.id}
                            title={bookmark.title}
                            url={bookmark.url}
                            date_added={bookmark.date_added}
                            handleUpdateBookMark={handleUpdateBookMark}
                            handleDeleteBookMark={handleDeleteBookMark}
                        />
                    ))
                )}
            </div>
        </div>
    )
}

export default Home;