<template>
    <Player playsinline ref="player">
        <Video :poster="image">
            <source :data-src="video" type="video/mp4"/>
        </Video>

        <Ui>
            <click-to-play/>
            <poster/>
            <spinner/>
            <Controls activeDuration="2750" fullWidth hideOnMouseLeave>
                <ControlGroup>
                    <ScrubberControl/>
                </ControlGroup>

                <ControlGroup space="top">
                    <PlaybackControl tooltip-direction="right"/>
                    <VolumeControl/>
                    <ControlSpacer/>
                    <FullscreenControl keys="f" tooltip-direction="left"/>
                </ControlGroup>
            </Controls>
        </Ui>
    </Player>
</template>

<script>
import {
    Player,
    Video,
    Ui,
    ClickToPlay,
    Poster,
    Spinner,
    Controls,
    ControlGroup,
    ScrubberControl,
    PlaybackControl,
    VolumeControl,
    TimeProgress,
    ControlSpacer,
    FullscreenControl,
    Control
} from '@vime/vue-next';

export default {
    name: "VideoPlayer",

    props: {
        image: String,
        video: String,
    },

    components: {
        Control,
        ControlGroup,
        Player,
        Video,
        Ui,
        ClickToPlay,
        Poster,
        Spinner,
        Controls,
        PlaybackControl,
        ScrubberControl,
        VolumeControl,
        TimeProgress,
        ControlSpacer,
        FullscreenControl,
    },
}
</script>
