import React from 'react';
import { render } from 'react-dom';
import Plyr from 'react-plyr';

const renderContainer = document.querySelector('.module.video');
const { videoId } = renderContainer.dataset;

const Video = () => (
  <div>
    <Plyr
      type='youtube'
      videoId={`${videoId}`}
    />
  </div>
);

render(<Video />, renderContainer);
