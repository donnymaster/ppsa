import Tabs from './components/tabs';
import Modal from './components/modal';
import InitTinyMCE from './components/tinymce';
import Drop from './components/drop';
import RangeInput from './components/range';
import SearchInputAjax from './components/search';
import SearchByDirectory from './components/searchByDirectory';
import RangeMulti from './components/rangeMulti';
import IngredientsForm from './components/ingredientsForm';
import StepsRecipe from './components/stepsRecipeForm';
import Calendar from './components/calendar';
import Messanger from './components/messanger';
import menu from './components/menu';

// ------ Init Tabs ------
new Tabs();

// ------ Init Modal ------
new Modal();

// ------ Init TinyMCE ------
new InitTinyMCE();

// ------ Drop ------
new Drop();

// ------  Range ------
// new RangeInput();

// ------ SearchInputAjax ------
const search = new SearchInputAjax();

// ------ SearchByDirectory ------
new SearchByDirectory();

// ------ RangeMulti ------
new RangeMulti();

// ------ IngredientsForm ------
const ingredientsForm = new IngredientsForm();

ingredientsForm.pushHandler('add', () => {
    search.update();
});

ingredientsForm.pushHandler('delete', () => {
    search.update();
});

// ------ StepsRecipe ------
new StepsRecipe();

// ------ Calendar -------
new Calendar();


const imgs = document.querySelectorAll('.lightgallery');

if (imgs !== null) {
    imgs.forEach(item => {
        new ImgPreviewer('.lightgallery');
    });
}

new Messanger();

menu();
