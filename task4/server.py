"""
Simple HTTP Server to serve static HTML files.
This server uses Python's built-in http.server module.
"""

import http.server
import socketserver

# Server configuration
PORT = 8000
DIRECTORY = "."

class MyHandler(http.server.SimpleHTTPRequestHandler):
    """Custom handler to serve files from the current directory."""
    
    def __init__(self, *args, **kwargs):
        super().__init__(*args, directory=DIRECTORY, **kwargs)

def run_server():
    """Start the HTTP server."""
    with socketserver.TCPServer(("", PORT), MyHandler) as httpd:
        print(f"=" * 50)
        print(f"  Web Server Started Successfully!")
        print(f"=" * 50)
        print(f"\n  Server running at: http://localhost:{PORT}")
        print(f"  Serving files from: {DIRECTORY}")
        print(f"\n  Press Ctrl+C to stop the server")
        print(f"=" * 50)
        
        try:
            httpd.serve_forever()
        except KeyboardInterrupt:
            print("\n\nServer stopped.")

if __name__ == "__main__":
    run_server()
