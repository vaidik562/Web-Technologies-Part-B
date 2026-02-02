/**
 * Dynamic Web Application - Client-Side JavaScript
 * Features: Form Validation, AJAX Submissions, Dynamic Updates
 */

// ============== Tab Navigation ==============
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab and activate button
    document.getElementById(tabName + '-tab').classList.add('active');
    event.target.classList.add('active');

    // Clear any messages
    hideMessage();
}

// ============== Message Display ==============
function showMessage(message, isSuccess, elementId = 'message') {
    const msgEl = document.getElementById(elementId);
    if (msgEl) {
        msgEl.textContent = message;
        msgEl.className = 'message ' + (isSuccess ? 'success' : 'error');
        msgEl.classList.remove('hidden');

        // Auto-hide after 5 seconds
        setTimeout(() => {
            msgEl.classList.add('hidden');
        }, 5000);
    }
}

function hideMessage(elementId = 'message') {
    const msgEl = document.getElementById(elementId);
    if (msgEl) {
        msgEl.classList.add('hidden');
    }
}

// ============== Form Validation ==============
function validateLoginForm(username, password) {
    if (username === '') {
        alert('Username is required!');
        return false;
    }
    if (password === '') {
        alert('Password is required!');
        return false;
    }
    return true;
}

function validateRegisterForm(username, email, password) {
    if (username === '') {
        alert('Username is required!');
        return false;
    }
    if (email === '') {
        alert('Email is required!');
        return false;
    }
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address!');
        return false;
    }
    if (password === '') {
        alert('Password is required!');
        return false;
    }
    if (password.length < 6) {
        alert('Password must be at least 6 characters!');
        return false;
    }
    return true;
}

function validateEventForm(title) {
    if (title === '') {
        alert('Title is required!');
        return false;
    }
    return true;
}

// ============== AJAX Form Submissions ==============

// Login Form Handler
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent page reload

        const username = document.getElementById('login-username').value.trim();
        const password = document.getElementById('login-password').value;

        // Client-side validation
        if (!validateLoginForm(username, password)) {
            return;
        }

        // AJAX submission
        fetch('/login', {
            method: 'POST',
            body: new FormData(this)
        })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success);
                if (data.success && data.redirect) {
                    // Redirect to dashboard
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }
            })
            .catch(error => {
                showMessage('An error occurred. Please try again.', false);
                console.error('Error:', error);
            });
    });
}

// Registration Form Handler
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent page reload

        const username = document.getElementById('reg-username').value.trim();
        const email = document.getElementById('reg-email').value.trim();
        const password = document.getElementById('reg-password').value;

        // Client-side validation
        if (!validateRegisterForm(username, email, password)) {
            return;
        }

        // AJAX submission
        fetch('/register', {
            method: 'POST',
            body: new FormData(this)
        })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success);
                if (data.success) {
                    // Clear form and switch to login tab
                    this.reset();
                    setTimeout(() => {
                        document.querySelector('.tab-btn').click();
                    }, 1500);
                }
            })
            .catch(error => {
                showMessage('An error occurred. Please try again.', false);
                console.error('Error:', error);
            });
    });
}

// Event Form Handler
const eventForm = document.getElementById('eventForm');
if (eventForm) {
    eventForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent page reload

        const title = document.getElementById('title').value.trim();

        // Client-side validation
        if (!validateEventForm(title)) {
            return;
        }

        // AJAX submission
        fetch('/addevent', {
            method: 'POST',
            body: new FormData(this)
        })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success, 'event-message');
                if (data.success) {
                    // Clear form
                    this.reset();

                    // Dynamically add event to the list
                    addEventToList(data.event);
                }
            })
            .catch(error => {
                showMessage('An error occurred. Please try again.', false, 'event-message');
                console.error('Error:', error);
            });
    });
}

// ============== Dynamic Event Management ==============

function addEventToList(event) {
    const eventsList = document.getElementById('events-list');

    // Remove "no events" message if present
    const noEvents = eventsList.querySelector('.no-events');
    if (noEvents) {
        noEvents.remove();
    }

    // Create new event element
    const eventItem = document.createElement('div');
    eventItem.className = 'event-item';
    eventItem.id = 'event-' + event.id;

    let dateHtml = '';
    if (event.event_date) {
        dateHtml = `<span class="event-date">📆 ${event.event_date}</span>`;
    }

    let descHtml = '';
    if (event.description) {
        descHtml = `<p>${event.description}</p>`;
    }

    eventItem.innerHTML = `
        <div class="event-content">
            <h3>${event.title}</h3>
            ${descHtml}
            ${dateHtml}
        </div>
        <button class="btn btn-delete" onclick="deleteEvent(${event.id})">
            🗑️ Delete
        </button>
    `;

    // Add to top of list with animation
    eventItem.style.opacity = '0';
    eventsList.insertBefore(eventItem, eventsList.firstChild);

    setTimeout(() => {
        eventItem.style.transition = 'opacity 0.3s ease';
        eventItem.style.opacity = '1';
    }, 10);
}

function deleteEvent(eventId) {
    if (!confirm('Are you sure you want to delete this event?')) {
        return;
    }

    fetch('/deleteevent/' + eventId, {
        method: 'DELETE'
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove event from DOM with animation
                const eventItem = document.getElementById('event-' + eventId);
                if (eventItem) {
                    eventItem.style.transition = 'all 0.3s ease';
                    eventItem.style.opacity = '0';
                    eventItem.style.transform = 'translateX(50px)';
                    setTimeout(() => {
                        eventItem.remove();

                        // Check if list is empty
                        const eventsList = document.getElementById('events-list');
                        if (eventsList.children.length === 0) {
                            eventsList.innerHTML = '<p class="no-events">No events yet. Create your first event above!</p>';
                        }
                    }, 300);
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred. Please try again.');
            console.error('Error:', error);
        });
}

// ============== Initialize ==============
console.log('Dynamic Web Application loaded successfully!');
