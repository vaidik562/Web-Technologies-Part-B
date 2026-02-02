// Get DOM elements
const loadStudentsBtn = document.getElementById('loadStudents');
const loadCoursesBtn = document.getElementById('loadCourses');
const loadNewsBtn = document.getElementById('loadNews');
const clearDataBtn = document.getElementById('clearData');
const dataContainer = document.getElementById('dataContainer');
const loadingDiv = document.getElementById('loading');

// Event Listeners
loadStudentsBtn.addEventListener('click', () => loadData('students.json', displayStudents));
loadCoursesBtn.addEventListener('click', () => loadData('courses.json', displayCourses));
loadNewsBtn.addEventListener('click', () => loadData('news.json', displayNews));
clearDataBtn.addEventListener('click', clearData);

/**
 * Core AJAX function to load data asynchronously
 * @param {string} url - The URL/file to fetch
 * @param {function} callback - Function to handle the data
 */
function loadData(url, callback) {
    // Show loading indicator
    showLoading();
    
    // Create XMLHttpRequest object (traditional AJAX)
    const xhr = new XMLHttpRequest();
    
    // Configure the request
    xhr.open('GET', url, true);
    
    // Set up event handler for when request completes
    xhr.onload = function() {
        // Hide loading indicator
        hideLoading();
        
        if (xhr.status === 200) {
            // Success - parse JSON and call callback
            try {
                const data = JSON.parse(xhr.responseText);
                callback(data);
            } catch (error) {
                displayError('Error parsing data: ' + error.message);
            }
        } else {
            // Error handling
            displayError('Error loading data. Status: ' + xhr.status);
        }
    };
    
    // Handle network errors
    xhr.onerror = function() {
        hideLoading();
        displayError('Network error occurred');
    };
    
    // Send the request
    xhr.send();
}

/**
 * Alternative AJAX implementation using Fetch API (modern approach)
 * Uncomment this to use Fetch instead of XMLHttpRequest
 */
/*
function loadData(url, callback) {
    showLoading();
    
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            callback(data);
        })
        .catch(error => {
            hideLoading();
            displayError('Error: ' + error.message);
        });
}
*/

// Display functions for different data types
function displayStudents(data) {
    let html = '<h2 style="margin-bottom: 20px; color: #667eea;">Students List</h2>';
    
    data.students.forEach(student => {
        html += `
            <div class="data-card">
                <h3>${student.name}</h3>
                <p><strong>Student ID:</strong> ${student.id}</p>
                <p><strong>Programme:</strong> ${student.programme}</p>
                <p><strong>Email:</strong> ${student.email}</p>
                <span class="badge">${student.year}</span>
            </div>
        `;
    });
    
    dataContainer.innerHTML = html;
}

function displayCourses(data) {
    let html = '<h2 style="margin-bottom: 20px; color: #667eea;">Available Courses</h2>';
    
    data.courses.forEach(course => {
        html += `
            <div class="data-card">
                <h3>${course.code}: ${course.name}</h3>
                <p><strong>Lecturer:</strong> ${course.lecturer}</p>
                <p><strong>Credits:</strong> ${course.credits}</p>
                <p><strong>Description:</strong> ${course.description}</p>
                <span class="badge">${course.semester}</span>
            </div>
        `;
    });
    
    dataContainer.innerHTML = html;
}

function displayNews(data) {
    let html = '<h2 style="margin-bottom: 20px; color: #667eea;">Latest News</h2>';
    
    data.news.forEach(item => {
        html += `
            <div class="data-card">
                <h3>${item.title}</h3>
                <p>${item.content}</p>
                <p><strong>Date:</strong> ${item.date}</p>
                <p><strong>Author:</strong> ${item.author}</p>
            </div>
        `;
    });
    
    dataContainer.innerHTML = html;
}

function displayError(message) {
    dataContainer.innerHTML = `
        <div style="text-align: center; padding: 40px; color: #dc3545;">
            <h3>⚠️ Error</h3>
            <p>${message}</p>
            <p style="margin-top: 20px; font-size: 0.9em; color: #6c757d;">
                Make sure the JSON files are in the same directory as index.html
            </p>
        </div>
    `;
}

function clearData() {
    dataContainer.innerHTML = '<p class="placeholder">Click a button above to load data asynchronously using AJAX</p>';
}

function showLoading() {
    loadingDiv.classList.remove('hidden');
    dataContainer.innerHTML = '';
}

function hideLoading() {
    loadingDiv.classList.add('hidden');
}