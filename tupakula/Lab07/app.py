from flask import Flask, render_template, request, session, redirect, url_for, flash
from flask_sqlalchemy import SQLAlchemy
import re

app = Flask(__name__)
app.config['SECRET_KEY'] = 'your_secret_key'
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///site.db'
db = SQLAlchemy(app)

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    first_name = db.Column(db.String(50), nullable=False)
    last_name = db.Column(db.String(50), nullable=False)
    email = db.Column(db.String(100), unique=True, nullable=False)
    password = db.Column(db.String(100), nullable=False)

    def __repr__(self):
        return f"User('{self.email}')"

with app.app_context():
    db.create_all()

def validate_password(password):
    contains_lowercase = bool(re.search(r'[a-z]', password))
    contains_uppercase = bool(re.search(r'[A-Z]', password))
    ends_with_number = password[-1].isdigit()
    length_valid = len(password) >= 8
    return contains_lowercase, contains_uppercase, ends_with_number, length_valid

@app.before_request
def before_request():
    if 'failed_attempts' not in session:
        session['failed_attempts'] = 0

@app.route('/')
def index():
    return redirect(url_for('signin'))

@app.route('/signin', methods=['GET', 'POST'])
def signin():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']
        user = User.query.filter_by(email=email, password=password).first()

        if user:
            session['user_id'] = user.id
            session['failed_attempts'] = 0
            return redirect(url_for('secretPage'))
        else:
            session['failed_attempts'] += 1
            if session['failed_attempts'] >= 3:
                flash('Warning: 3 consecutive failed attempts. Please try again later.', 'danger')
            else:
                flash('Invalid credentials!', 'danger')
            return redirect(url_for('signin'))

    return render_template('signin.html')

@app.route('/signup', methods=['GET', 'POST'])
def signup():
    if request.method == 'POST':
        first_name = request.form['first_name']
        last_name = request.form['last_name']
        email = request.form['email']
        password = request.form['password']
        confirm_password = request.form['confirm_password']

        if password != confirm_password:
            flash('Passwords do not match!', 'danger')
            return render_template('signup.html', first_name=first_name, last_name=last_name, email=email)

        contains_lowercase, contains_uppercase, ends_with_number, length_valid = validate_password(password)

        if not (contains_lowercase and contains_uppercase and ends_with_number and length_valid):
            flash('Password does not meet criteria!', 'danger')
            return render_template('signup.html', first_name=first_name, last_name=last_name, email=email)

        existing_user = User.query.filter_by(email=email).first()
        if existing_user:
            return render_template('error.html', message='Email is already used! Please sign in or register with a different email.')

        new_user = User(first_name=first_name, last_name=last_name, email=email, password=password)
        db.session.add(new_user)
        db.session.commit()

        return render_template('thankyou.html', first_name=first_name)

    return render_template('signup.html')

@app.route('/secretPage')
def secretPage():
    if 'user_id' not in session:
        flash('You need to sign in first!', 'danger')
        return redirect(url_for('signin'))
    return render_template('secretPage.html')

@app.route('/logout')
def logout():
    session.pop('user_id', None)
    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)
