import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ReactPlayer from 'react-player';

const renderContainer = document.querySelector('.module.video');

class Video extends Component {
  constructor(props) {
    super(props);

    const { videoId } = renderContainer.dataset;

    this.state = {
      videoUrl: `https://vimeo.com/${videoId}`,
    };
  }

  render() {
    return (
      <ReactPlayer
        url={this.state.videoUrl}
        controls='false'
        loop='true'
        playing
        volume='0' />
    );
  }
}

ReactDOM.render(<Video />, renderContainer);
