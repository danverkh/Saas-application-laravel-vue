<template>
    <Modal name="login-modal" width="max-w-sm" overflow="overflow-visible" classes="p-9">
        <div class="text-center text-4xl font-bold mb-2 px-5">Login</div>
        <div class="text-center text-md font-medium text-zinc-400 mb-6 px-5">Use your email and password to login into your account</div>
        <LoginForm class="flex-col" type="modal"/>
    </Modal>
</template>

<script>
import Modal from "./Modal.vue";
import LoginForm from "@/pages/layout/LoginForm.vue";

export default {
    name: "LoginModal",

    components: {LoginForm, Modal},
}
</script>
