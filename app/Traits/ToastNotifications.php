<?php
// app/Traits/ToastNotifications.php

namespace App\Traits;

trait ToastNotifications
{
    /**
     * Dispatch a success toast notification.
     */
    protected function toastSuccess(
        string $message,
        ?string $title = null,
        $options = [],
    ): void {
        $this->dispatch(
            "toastMagic",
            status: "success",
            title: $title ?: __("messages.success"),
            message: $message,
            options: $options,
        );
    }

    /**
     * Dispatch an error toast notification.
     */
    protected function toastError(
        string $message,
        ?string $title = null,
        $options = [],
    ): void {
        $this->dispatch(
            "toastMagic",
            status: "error",
            title: $title ?: __("messages.error"),
            message: $message,
            options: $options,
        );
    }

    /**
     * Dispatch a warning toast notification.
     */
    protected function toastWarning(
        string $message,
        ?string $title = null,
        $options = [],
    ): void {
        $this->dispatch(
            "toastMagic",
            status: "warning",
            title: $title ?: __("messages.warning"),
            message: $message,
            options: $options,
        );
    }

    /**
     * Dispatch an info toast notification.
     */
    protected function toastInfo(
        string $message,
        ?string $title = null,
        $options = [],
    ): void {
        $this->dispatch(
            "toastMagic",
            status: "info",
            title: $title ?: __("messages.info"),
            message: $message,
            options: $options,
        );
    }

    /**
     * Generic toast method with custom status.
     */
    protected function toast(
        string $status,
        string $message,
        ?string $title = null,
        $options = [],
    ): void {
        $this->dispatch(
            "toastMagic",
            status: $status,
            title: $title ?: __("messages.{$status}"),
            message: $message,
            options: $options,
        );
    }
}
