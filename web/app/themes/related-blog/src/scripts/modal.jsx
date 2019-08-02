import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class NewsletterModal extends Component {
  constructor(props) {
    super(props);

    this.state = {
      isActive: 'is-active',
    };
  }

  render() {
    return (
      <div
        className={`modal ${this.state.isActive}`}
      >
        <div className="modal-background"></div>
        <div className="modal-card">
          <header className="modal-card-head">
            <p className="modal-card-title">Modal title</p>
            <button className="delete" aria-label="close"></button>
          </header>
          <section className="modal-card-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
            mollit anim id est laborum.</p>
          </section>
          <footer className="modal-card-foot">
          </footer>
        </div>
      </div>
    );
  }
}

class NewsletterModalButton extends Component {
  constructor(props) {
    super(props);

    this.handleClick = this.handleClick.bind(this);

    this.state = {
      isActive: '',
    };
  }

  handleClick() {
    this.setState({
      isActive: 'is-active',
    });

    ReactDOM.render(<NewsletterModal isActive={this.state.isActive} />, document.querySelector('#newsletterModal'));
  }

  render() {
    return (
      <div>
        <button
          className="modal-button"
          data-target="modal"
          aria-haspopup="true"
          onClick={() => this.handleClick()}
        >Newsletter signup
        </button>
      </div>
    );
  }
}

ReactDOM.render(<NewsletterModalButton />, document.querySelector('.newsletter-signup'));
