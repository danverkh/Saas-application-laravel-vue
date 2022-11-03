<template>
    <Modal name="cancel-keyword-confirmation" title-class="text-red-600" title="Cancel keyword">
        <div class="mt-2">Are you sure you want to cancel this keyword?</div>

        <div class="modal-action">
            <button @click="close" class="btn px-8">No</button>
            <button @click="submit" class="btn bg-red-600 border-red-700 hover:bg-red-700 hover:border-red-800">Yes, I'm sure</button>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/components/Modal.vue";
import ModalService from "@/services/Modal";

export default {
    name: "DeleteConfirmation",

    components: {Modal},

    methods: {
        submit() {
            alert('Not implemented');
            this.close();
        },

        close() {
            ModalService.close('cancel-keyword-confirmation');
        },
    },
}
</script>
