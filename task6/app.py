"""
Dynamic Web Application - Flask Server
Unit 6 Consolidate - Task 1
Features: User Authentication, Database Integration, Interactive Forms
"""

from flask import Flask, render_template, request, jsonify, session, redirect, url_for
import sqlite3
import hashlib
import os
from datetime import datetime

app = Flask(__name__)
app.secret_key = 'your-secret-key-here-change-in-production'

DATABASE = 'database.db'

def get_db():
    """Get database connection."""
    conn = sqlite3.connect(DATABASE)
    conn.row_factory = sqlite3.Row
    return conn

def init_db():
    """Initialize database with tables."""
    conn = get_db()
    cursor = conn.cursor()
    
    # Create users table
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ''')
    
    # Create events table
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS events (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            title TEXT NOT NULL,
            description TEXT,
            event_date DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users (id)
        )
    ''')
    
    conn.commit()
    conn.close()

def hash_password(password):
    """Hash password using SHA256."""
    return hashlib.sha256(password.encode()).hexdigest()

# Initialize database on startup
init_db()

# ============== ROUTES ==============

@app.route('/')
def index():
    """Home page with login/register forms."""
    if 'user_id' in session:
        return redirect(url_for('dashboard'))
    return render_template('index.html')

@app.route('/register', methods=['POST'])
def register():
    """Handle user registration via AJAX."""
    data = request.form
    username = data.get('username', '').strip()
    email = data.get('email', '').strip()
    password = data.get('password', '')
    
    # Server-side validation
    if not username or not email or not password:
        return jsonify({'success': False, 'message': 'All fields are required!'})
    
    if len(password) < 6:
        return jsonify({'success': False, 'message': 'Password must be at least 6 characters!'})
    
    try:
        conn = get_db()
        cursor = conn.cursor()
        cursor.execute(
            'INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)',
            (username, email, hash_password(password))
        )
        conn.commit()
        conn.close()
        return jsonify({'success': True, 'message': 'Registration successful! Please login.'})
    except sqlite3.IntegrityError:
        return jsonify({'success': False, 'message': 'Username or email already exists!'})

@app.route('/login', methods=['POST'])
def login():
    """Handle user login via AJAX."""
    data = request.form
    username = data.get('username', '').strip()
    password = data.get('password', '')
    
    if not username or not password:
        return jsonify({'success': False, 'message': 'All fields are required!'})
    
    conn = get_db()
    cursor = conn.cursor()
    cursor.execute(
        'SELECT id, username FROM users WHERE username = ? AND password_hash = ?',
        (username, hash_password(password))
    )
    user = cursor.fetchone()
    conn.close()
    
    if user:
        session['user_id'] = user['id']
        session['username'] = user['username']
        return jsonify({'success': True, 'message': 'Login successful!', 'redirect': '/dashboard'})
    else:
        return jsonify({'success': False, 'message': 'Invalid username or password!'})

@app.route('/logout')
def logout():
    """Handle user logout."""
    session.clear()
    return redirect(url_for('index'))

@app.route('/dashboard')
def dashboard():
    """User dashboard - requires authentication."""
    if 'user_id' not in session:
        return redirect(url_for('index'))
    
    conn = get_db()
    cursor = conn.cursor()
    cursor.execute(
        'SELECT * FROM events WHERE user_id = ? ORDER BY created_at DESC',
        (session['user_id'],)
    )
    events = cursor.fetchall()
    conn.close()
    
    return render_template('dashboard.html', username=session['username'], events=events)

@app.route('/addevent', methods=['POST'])
def add_event():
    """Add new event via AJAX."""
    if 'user_id' not in session:
        return jsonify({'success': False, 'message': 'Please login first!'})
    
    data = request.form
    title = data.get('title', '').strip()
    description = data.get('description', '').strip()
    event_date = data.get('event_date', '')
    
    if not title:
        return jsonify({'success': False, 'message': 'Event title is required!'})
    
    conn = get_db()
    cursor = conn.cursor()
    cursor.execute(
        'INSERT INTO events (user_id, title, description, event_date) VALUES (?, ?, ?, ?)',
        (session['user_id'], title, description, event_date if event_date else None)
    )
    event_id = cursor.lastrowid
    conn.commit()
    conn.close()
    
    return jsonify({
        'success': True, 
        'message': 'Event added successfully!',
        'event': {
            'id': event_id,
            'title': title,
            'description': description,
            'event_date': event_date
        }
    })

@app.route('/deleteevent/<int:event_id>', methods=['DELETE'])
def delete_event(event_id):
    """Delete event via AJAX."""
    if 'user_id' not in session:
        return jsonify({'success': False, 'message': 'Please login first!'})
    
    conn = get_db()
    cursor = conn.cursor()
    cursor.execute(
        'DELETE FROM events WHERE id = ? AND user_id = ?',
        (event_id, session['user_id'])
    )
    conn.commit()
    conn.close()
    
    return jsonify({'success': True, 'message': 'Event deleted successfully!'})

if __name__ == '__main__':
    print("=" * 50)
    print("  Dynamic Web Application Server")
    print("=" * 50)
    print("\n  Server running at: http://localhost:5000")
    print("  Press Ctrl+C to stop the server")
    print("=" * 50)
    app.run(debug=True, port=5000)
