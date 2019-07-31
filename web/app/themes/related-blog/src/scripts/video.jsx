/* eslint-disable react/no-unknown-property */
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Plyr from 'plyr';

const renderContainer = document.querySelector('.module.video');

class Video extends Component {
  constructor(props) {
    super(props);

    const { videoId } = renderContainer.dataset;

    this.state = {
      videoId,
    };
  }

  componentDidMount() {
    this.player = new Plyr('#player', {
      enabled: true,
      controls: ['play'],
      settings: ['loop'],
      autoplay: true,
      volume: 0,
      muted: true,
      clickToPlay: true,
      hideControls: true,
      resetOnEnd: true,
      displayDuration: false,
      fullscreen: { enabled: true, fallback: true, iosNative: false },
    });
    console.log('player', this.player);
  }

  render() {
    return (
      <div className="plyr__video-embed" id="player">
        <iframe
          src={`https://player.vimeo.com/video/${this.state.videoId}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media`}
          allowfullscreen
          allowtransparency
          allow="autoplay; fullscreen"
        ></iframe>
      </div>
    );
  }
}

if (renderContainer) {
  ReactDOM.render(<Video />, renderContainer);
}
