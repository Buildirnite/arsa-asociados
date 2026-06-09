import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'
import Underline from '@tiptap/extension-underline'

document.addEventListener('DOMContentLoaded', () => {
    const editorEl  = document.getElementById('editor')
    const inputEl   = document.getElementById('content-input')

    if (!editorEl || !inputEl) return

    const editor = new Editor({
        element: editorEl,
        extensions: [
            StarterKit,
            Underline,
            Image.configure({ inline: false, allowBase64: false }),
            Link.configure({ openOnClick: false, autolink: true }),
        ],
        content: inputEl.value || '',
        editorProps: {
            attributes: {
                class: 'prose prose-slate prose-sm max-w-none min-h-[420px] px-6 py-5 focus:outline-none',
            },
            handlePaste: (view, event) => insertDroppedImages(event.clipboardData?.files),
            handleDrop:  (view, event) => insertDroppedImages(event.dataTransfer?.files),
        },
        onUpdate({ editor }) {
            inputEl.value = editor.getHTML()
            // Notifica al formulario (contador de palabras, autoguardado, semáforo…)
            inputEl.dispatchEvent(new Event('input', { bubbles: true }))
        },
    })

    const token = document.querySelector('meta[name="csrf-token"]')?.content

    // --- Subida de imágenes: reutilizada por el botón, arrastrar y pegar ---
    async function uploadImage(file) {
        const formData = new FormData()
        formData.append('image', file)
        formData.append('_token', token)
        const res  = await fetch('/admin/upload-image', { method: 'POST', body: formData })
        const data = await res.json()
        return data.url
    }

    async function insertImage(file) {
        try {
            const url = await uploadImage(file)
            if (url) editor.chain().focus().setImage({ src: url, alt: file.name }).run()
        } catch {
            alert('Error al subir la imagen. Intente nuevamente.')
        }
    }

    function insertDroppedImages(fileList) {
        const images = Array.from(fileList || []).filter(f => f.type.startsWith('image/'))
        if (!images.length) return false
        images.forEach(insertImage)
        return true
    }

    const actions = {
        bold:         () => editor.chain().focus().toggleBold().run(),
        italic:       () => editor.chain().focus().toggleItalic().run(),
        underline:    () => editor.chain().focus().toggleUnderline().run(),
        h2:           () => editor.chain().focus().toggleHeading({ level: 2 }).run(),
        h3:           () => editor.chain().focus().toggleHeading({ level: 3 }).run(),
        bulletList:   () => editor.chain().focus().toggleBulletList().run(),
        orderedList:  () => editor.chain().focus().toggleOrderedList().run(),
        blockquote:   () => editor.chain().focus().toggleBlockquote().run(),
        hr:           () => editor.chain().focus().setHorizontalRule().run(),
        undo:         () => editor.chain().focus().undo().run(),
        redo:         () => editor.chain().focus().redo().run(),
        link: () => {
            const prev = editor.getAttributes('link').href
            const url  = prompt('URL del enlace:', prev || 'https://')
            if (url === null) return
            url === ''
                ? editor.chain().focus().unsetLink().run()
                : editor.chain().focus().setLink({ href: url, target: '_blank' }).run()
        },
        image: () => {
            const input = document.createElement('input')
            input.type   = 'file'
            input.accept = 'image/jpeg,image/png,image/webp'
            input.onchange = () => {
                if (input.files[0]) insertImage(input.files[0])
            }
            input.click()
        },
    }

    document.querySelectorAll('[data-editor-action]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            const action = btn.dataset.editorAction
            if (actions[action]) actions[action]()
        })
    })

    function updateActiveStates() {
        const map = {
            bold:        editor.isActive('bold'),
            italic:      editor.isActive('italic'),
            underline:   editor.isActive('underline'),
            h2:          editor.isActive('heading', { level: 2 }),
            h3:          editor.isActive('heading', { level: 3 }),
            bulletList:  editor.isActive('bulletList'),
            orderedList: editor.isActive('orderedList'),
            blockquote:  editor.isActive('blockquote'),
            link:        editor.isActive('link'),
        }
        document.querySelectorAll('[data-editor-action]').forEach(btn => {
            const active = map[btn.dataset.editorAction] ?? false
            btn.classList.toggle('bg-midnight-900', active)
            btn.classList.toggle('text-white', active)
            btn.classList.toggle('text-midnight-600', !active)
            btn.classList.toggle('hover:bg-midnight-100', !active)
        })
    }

    editor.on('selectionUpdate', updateActiveStates)
    editor.on('transaction', updateActiveStates)

    // Restaurar contenido desde un borrador autoguardado (form.blade.php)
    window.addEventListener('restore-editor', (e) => {
        editor.commands.setContent(e.detail || '')
    })
})
