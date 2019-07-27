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

  render() {
    return (
      <ReactPlayer url={this.state.videoUrl} playing loop='true' volume='0' controls='false' />
    );
  }
}

ReactDOM.render(<Video />, renderContainer);
