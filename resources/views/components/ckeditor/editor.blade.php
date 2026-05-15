<!-- CKEditor Professional Integration -->
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

<style>
    /* Professional Editor Container */
    .editor-wrapper {
        background: #ffffff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .editor-wrapper:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .editor-label {
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #475569;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }

    .editor-label i {
        color: #3b82f6;
        font-size: 1.1rem;
    }

    /* CKEditor Custom Overrides */
    :root {
        --ck-border-radius: 12px !important;
        --ck-color-base-border: #e2e8f0 !important;
        --ck-color-toolbar-background: #f8fafc !important;
        --ck-custom-white: #ffffff;
    }

    /* Make the writing area feel spacious */
    .ck-editor__editable_inline {
        min-height: 250px !important;
        padding: 20px 30px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 1rem !important;
        line-height: 1.6 !important;
        color: #1e293b !important;
    }

    /* Professional Toolbar Styling */
    .ck.ck-toolbar {
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        padding: 5px !important;
    }

    .ck.ck-button:hover {
        background: #eff6ff !important;
    }
    
    .ck.ck-button.ck-on {
        background: #dbeafe !important;
        color: #2563eb !important;
    }
</style>

<div class="editor-wrapper mb-4">
    <label for="editor" class="editor-label">
        <i class="bi bi-pencil-square me-2"></i> Composition / Notes
    </label>
    
    <!-- Original Logic: Dynamic Name -->
    <textarea name="{{$name}}" id="editor" placeholder="Start typing your professional notes here...">
        {{ $value ?? '' }}
    </textarea>
    
    <div class="mt-2 text-end">
        <small class="text-muted" style="font-size: 0.7rem;">
            <i class="bi bi-info-circle me-1"></i> Rich text formatting is auto-saved
        </small>
    </div>
</div>

<script>
    // Original Logic: Disallow Nesting Tables
    function DisallowNestingTables( editor ) {
        editor.model.schema.addChildCheck( ( context, childDefinition ) => {
            if ( childDefinition.name == 'table' && Array.from( context.getNames() ).includes( 'table' ) ) {
                return false;
            }
        } );
    }

    ClassicEditor.create( document.querySelector( '#editor' ), {
        extraPlugins: [ DisallowNestingTables ],
        // High-Level Toolbar Setup
        toolbar: {
            items: [
                'heading', '|', 
                'bold', 'italic', 'link', '|', 
                'insertTable', 'numberedList', 'bulletedList', '|', 
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        table: {
            toolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
        },
        placeholder: 'Write something extraordinary...'
    }).then( editor => {
        // High-Level focus effect
        editor.editing.view.document.on( 'change:isFocused', ( evt, name, isFocused ) => {
            if ( isFocused ) {
                document.querySelector('.editor-wrapper').style.borderColor = '#3b82f6';
            } else {
                document.querySelector('.editor-wrapper').style.borderColor = '#e2e8f0';
            }
        } );
    }).catch( error => {
        console.error( error );
    } );
</script>