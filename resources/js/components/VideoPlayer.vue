<template>
    <Player playsinline ref="player" :volume="80">
        <Video :poster="image">
            <source :data-src="video" type="video/mp4"/>
        </Video>

        <Ui>
            <Spinner/>
            <ClickToPlay/>
            <Poster/>

            <Controls activeDuration="2750" fullWidth hideOnMouseLeave>
                <ControlGroup>
                    <ScrubberControl/>
                </ControlGroup>

                <ControlGroup space="top">
                    <PlaybackControl hideTooltip/>
                    <VolumeControl hideTooltip/>
                    <ControlSpacer/>
                    <FullscreenControl keys="f" hideTooltip/>
                </ControlGroup>
            </Controls>
        </Ui>
    </Player>
</template>

<script>
import {
    ClickToPlay,
    Control,
    ControlGroup,
    ControlSpacer,
    Controls,
    FullscreenControl,
    PlaybackControl,
    Player,
    Poster,
    ScrubberControl,
    Spinner,
    TimeProgress,
    Ui,
    Video,
    VolumeControl,
} from '@vime/vue-next';

export default {
    name: "VideoPlayer",

    props: {
        image: String,
        video: String,
    },

    components: {
        ClickToPlay,
        Control,
        ControlGroup,
        ControlSpacer,
        Controls,
        FullscreenControl,
        PlaybackControl,
        Player,
        Poster,
        ScrubberControl,
        Spinner,
        TimeProgress,
        Ui,
        Video,
        VolumeControl,
    },
}
</script>

<style scoped>
vm-player {
    --vm-player-theme: #DD2B47;
    --vm-slider-thumb-bg: #222;
    --vm-control-color: #222;
    --vm-slider-thumb-border: #222;
    --vm-slider-track-color: #222;
}

vm-spinner {
    --vm-spinner-fill-color: #DD2B47;
    --vm-spinner-track-color: rgba(0,0,0, 0.2);
    --vm-spinner-thickness: 8px;
    --vm-spinner-width: 50px;
    --vm-spinner-height: 50px;
}
</style>
