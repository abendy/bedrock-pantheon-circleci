import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ReactPlayer from 'react-player';

const renderContainer = document.querySelector('.module.video');

class Video extends Component {
  constructor(props) {
    super(props);

    const { videoId } = renderContainer.dataset;

    this.state = {
      videoUrl: `https://www.youtube.com/watch?v=${videoId}`,
    };
  }

  // eslint-disable-next-line class-methods-use-this
  render() {
    return (
      <ReactPlayer url={this.state.videoUrl} playing volume='0' />
    );
  }
}

ReactDOM.render(<Video />, renderContainer);
