document
  .querySelectorAll('.add_item_link')
  .forEach(btn => {
      btn.addEventListener("click", addFormToCollection);
      console.log('click');
  });

document
    .querySelectorAll('ul.mealProducts li')
    .forEach((tag) => {
        addFormDeleteLink(tag)
    })

function addFormDeleteLink(item) {
    const removeFormButton = document.createElement('button');
    removeFormButton.innerText = 'Delete';
    removeFormButton.className = "btn btn-danger mb-3"
    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the li for the tag form
        item.remove();
    });
}

function addFormToCollection(e) {
  const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
  const item = document.createElement('li');
  item.className = 'list-group-item d-flex gap-3 align-items-end'
  item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
      /__name__/g,
      collectionHolder.dataset.index
    );
  item.children[0].className = "d-flex gap-3";

  collectionHolder.appendChild(item);

  collectionHolder.dataset.index++;

  addFormDeleteLink(item);
};
