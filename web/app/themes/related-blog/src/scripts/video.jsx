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
      disableContextMenu: true,
      hideControls: true,
      resetOnEnd: true,
      displayDuration: false,
      fullscreen: { enabled: true, fallback: true, iosNative: false },
      loop: { active: true },
      vimeo: {
        byline: false, portrait: false, title: false, speed: true, transparent: false, gesture: 'media',
      },
    });
  }

  render() {
    return (
      <div className="plyr__video-embed" id="player">
        <iframe
          src={`https://player.vimeo.com/video/${this.state.videoId}`}
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
