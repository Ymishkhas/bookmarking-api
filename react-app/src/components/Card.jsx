import { PencilSquareIcon, TrashIcon } from "@heroicons/react/16/solid";
import { useState } from "react";


const Card = ({ id, title, url, date_added, handleUpdateBookMark, handleDeleteBookMark }) => {

    const [bookmarkTitle, setBookmarkTitle] = useState(title);
    const [bookmarkUrl, setBookmarkUrl] = useState(url);
    const [showUpdateField, setShowUpdateField] = useState(false);
    const mainUrl = new URL(url).origin;

    const handleTitleInputChange = (event) => {
        event.preventDefault();
        event.stopPropagation();
        setBookmarkTitle(event.target.value);
    };

    const handleUrlInputChange = (event) => {
        event.preventDefault();
        event.stopPropagation();
        setBookmarkUrl(event.target.value);
    };

    const updateBookmark = (event) => {
        if (event.keyCode === 13 && event.target.value) {
            handleUpdateBookMark(id, bookmarkTitle, bookmarkUrl);
            setShowUpdateField(false);
        }
    }

    const deleteBookmarkButton = (e) => {
        e.preventDefault();
        e.stopPropagation();
        handleDeleteBookMark(id)
    }

    const EditBookmarkButton = (e) => {
        e.preventDefault();
        e.stopPropagation();
        setShowUpdateField(true);
    }

    const stopRedirect = (e) => {
        // Prevent redirect when clicking on the card while editing the bookmark
        if (showUpdateField) {
            e.preventDefault();
        }
    };


    return (
        <a className="ref" href={url} target="_blank" onClick={stopRedirect}>
            <div className="bookmark-card">
                <img className="url-icon" src={`${mainUrl}/favicon.ico`} alt="" />
                <div className="card-info">
                    {showUpdateField ? (
                        <>
                            <input
                                type='text'
                                value={bookmarkTitle}
                                onChange={handleTitleInputChange}
                                onBlur={() => setShowUpdateField(false)}
                                onKeyDown={updateBookmark}
                                autoFocus
                            />
                            <input
                                type='text'
                                value={bookmarkUrl}
                                onChange={handleUrlInputChange}
                                onBlur={() => setShowUpdateField(false)}
                                onKeyDown={updateBookmark}
                            />
                        </>
                    ) : (
                        <>
                            <label>{bookmarkTitle}</label>
                            <label>{bookmarkUrl}</label>
                        </>
                    )}

                </div>
                <div className="buttons-container">
                    <button className="icon-button" onClick={(e) => EditBookmarkButton(e)}><PencilSquareIcon className="icon" /></button>
                    <button className="icon-button" onClick={(e) => deleteBookmarkButton(e)}><TrashIcon className="icon" style={{ color: "red" }} /></button>
                </div>

            </div>
        </a>
    )
}

export default Card;