// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', () => {
    const { select, dispatch, subscribe } = wp.data;

    // Function to inject the dropdown into the block inspector
    function injectDropdown() {
        const sidebar = document.querySelector('.block-editor-block-inspector');

        if (!sidebar) return; // Exit if the inspector is not available

        // Avoid duplicate dropdowns
        if (sidebar.querySelector('.group-class-selector')) return;

        // Create dropdown container
        const dropdownContainer = document.createElement('div');
        dropdownContainer.className = 'components-panel__body group-class-selector';
        dropdownContainer.innerHTML = `
            <h3 class="components-panel__body-title">Background Class</h3>
            <select id="group-class-dropdown" style="width: 100%; margin-top: 0.5em;">
                <option value="">None</option>
                <option value="brightbg">Bright Background</option>
                <option value="darkbg">Dark Background</option>
                <option value="site-block">Site Block</option>
            </select>
        `;

        // Append dropdown to the sidebar
        sidebar.appendChild(dropdownContainer);

        // Add event listener for dropdown changes
        const dropdown = dropdownContainer.querySelector('#group-class-dropdown');
        dropdown.addEventListener('change', (event) => {
            const selectedClass = event.target.value;
            const block = select('core/block-editor').getSelectedBlock();

            if (block && block.name === 'core/group') {
                // Get the current classes from the Additional CSS Class(es) field
                const currentClasses = block.attributes.className || '';

                // Filter out existing dropdown-related classes
                const filteredClasses = currentClasses
                    .split(' ')
                    .filter((cls) => !['brightbg', 'darkbg', 'site-block'].includes(cls))
                    .join(' ');

                // Add the selected dropdown class
                const updatedClasses = selectedClass
                    ? `${filteredClasses} ${selectedClass}`.trim()
                    : filteredClasses;

                // Update the block's className attribute
                dispatch('core/block-editor').updateBlockAttributes(block.clientId, {
                    className: updatedClasses,
                });
            }
        });

        // Synchronize dropdown with the currently selected block
        subscribe(() => {
            const block = select('core/block-editor').getSelectedBlock();

            if (block && block.name === 'core/group') {
                const { className = '' } = block.attributes;
                const existingClass = className.split(' ').find((cls) =>
                    ['brightbg', 'darkbg', 'site-block'].includes(cls)
                );

                dropdown.value = existingClass || ''; // Update dropdown value
            }
        });
    }

    // Observe changes in the editor to inject the dropdown when a Group block is selected
    subscribe(() => {
        const block = select('core/block-editor').getSelectedBlock();

        if (block && block.name === 'core/group') {
            injectDropdown();
        }
    });
});

console.log('group-class-selector.js loaded');
