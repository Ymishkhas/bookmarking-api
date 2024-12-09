const ENDPOINT = 'http://localhost:9000/api';
const API_KEY = 'booking-api';

const createBookMark = async (data) => {
    try {
        const response = await fetch(`${ENDPOINT}/create.php`, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${API_KEY}`
            }
        });

        if (!response.ok) {
            throw new Error('Error creating a bookmark');
        }

        return await response.json();
    } catch (error) {
        console.error('Error creating a bookmark:', error.message);
        throw error;
    }
};

const readOneBookMark = async (id, user_id) => {
    try{
        const response = await fetch(`${ENDPOINT}/readOne.php?id=${id}&user_id=${user_id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${API_KEY}`
            }
        });

        if (!response.ok) {
            throw new Error('Error reading a bookmark')
        }

        return await response.json();
    } catch(error) {
        console.error('Error reading a bookmark: ', error.message);
        throw error;
    }
}

const readAllBookMarks = async (user_id) => {
    try{
        const response = await fetch(`${ENDPOINT}/readAll.php?user_id=${user_id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${API_KEY}`
            }
        });

        if (!response.ok) {
            throw new Error('Error reading user bookmarks')
        }

        return await response.json();
    } catch(error) {
        console.error('Error reading user bookmarks: ', error.message);
        throw error;
    }
}

const readMostClickedBookMarks = async (user_id) => {
    try{
        const response = await fetch(`${ENDPOINT}/readMostClicked.php?user_id=${user_id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${API_KEY}`
            }
        });

        if (!response.ok) {
            throw new Error('Error reading user most clicked bookmarks')
        }

        return await response.json();
    } catch(error) {
        console.error('Error reading user most clicked bookmarks: ', error.message);
        throw error;
    }
}

const updateBookMark = async (data) => {
    try {
        const response = await fetch(`${ENDPOINT}/update.php`, {
            method: 'PUT',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${API_KEY}`
            }
        });

        if (!response.ok) {
            throw new Error('Error updating a bookmark');
        }

        return await response.json();
    } catch (error) {
        console.error('Error updating a bookmark:', error.message);
        throw error;
    }
}

const updateClicksCountBookMark = async (data) => {
    try {
        const response = await fetch(`${ENDPOINT}/updateClicksCount.php`, {
            method: 'PUT',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${API_KEY}`
            }
        });

        if (!response.ok) {
            throw new Error('Error updating clicks count of a bookmark');
        }

        return await response.json();
    } catch (error) {
        console.error('Error updating clicks count of a bookmark:', error.message);
        throw error;
    }
}

const deleteBookMark = async (data) => {
    try {
        const response = await fetch(`${ENDPOINT}/delete.php`, {
            method: 'DELETE',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${API_KEY}`
            }
        });

        if (!response.ok) {
            throw new Error('Error deleting a bookmark');
        }

        return await response.json();
    } catch (error) {
        console.error('Error deleting a bookmark:', error.message);
        throw error;
    }
}

export { createBookMark, readOneBookMark, readAllBookMarks, readMostClickedBookMarks, updateBookMark, updateClicksCountBookMark, deleteBookMark };