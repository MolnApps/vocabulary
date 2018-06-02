import { mount } from '@vue/test-utils';
import expect from 'expect';
import VocabularyGameQuestion from '../../resources/assets/js/components/VocabularyGameQuestion.vue';

describe ('VocabularyGameQuestion', () => {
	let wrapper; 

	beforeEach(() => {
		wrapper = mount(VocabularyGameQuestion, {
			propsData: {
				'word': {word: 'Hello', pronounce: 'Ciao', translation: 'Ciao'},
				'options': [
					{word: 'Hello', pronounce: 'Ciao', translation: 'Ciao'},
					{word: 'Man', pronounce: 'Uomo', translation: 'Uomo'},
					{word: 'Woman', pronounce: 'Donna', translation: 'Donna'}
				],
				'index': 0
			}
		});
	}),

	it ('renders a word and some options', () => {
		expect(wrapper.html()).toContain('<h2 class="question-word">Ciao</h2>');
		expect(wrapper.html()).toContain('<em>Ciao</em>');
		expect(wrapper.find('ul').text()).toContain('Hello');
		expect(wrapper.find('ul').text()).toContain('Man');
		expect(wrapper.find('ul').text()).toContain('Woman');
	});

	it ('marks itself as right if the user gives the correct answer', () => {
		expect(wrapper.classes()).not.toContain(['question-is-correct']);
		
		answer('Hello').trigger('click');
		
		expect(wrapper.classes()).toContain('question-is-correct');
	});
	
	it ('marks itself as wrong if the user gives the wrong answer', () => {
		expect(wrapper.classes()).not.toContain(['question-is-wrong']);
		
		answer('Man').trigger('click');
		
		expect(wrapper.classes()).toContain('question-is-wrong');
	});
	
	it ('marks the given answer as wrong and highlights the solution if the user gives the wrong answer', () => {
		expect(answer('Hello').classes()).not.toContain('answer-is-correct');
		expect(answer('Man').classes()).not.toContain('answer-is-wrong');
		expect(answer('Woman').classes()).not.toContain('answer-is-wrong');

		answer('Man').trigger('click');

		expect(answer('Hello').classes()).toContain('answer-is-correct');
		expect(answer('Man').classes()).toContain('answer-is-wrong');
		expect(answer('Woman').classes()).not.toContain('answer-is-wrong');
	});

	it ('will not allow to answer twice', () => {
		expect(wrapper.classes()).not.toContain(['question-is-wrong']);
		expect(wrapper.classes()).not.toContain(['question-is-correct']);
		
		answer('Man').trigger('click');
		
		expect(wrapper.classes()).toContain('question-is-wrong');

		answer('Hello').trigger('click');
		
		expect(wrapper.classes()).toContain('question-is-wrong');
		expect(wrapper.classes()).not.toContain('question-is-correct');
	});

	it ('broadcasts an event when the user answers a question', () => {
		answer('Man').trigger('click');

		expect(wrapper.emitted()).toBeTruthy();
		expect(wrapper.emitted().giveAnswer[0]).toContainEqual({index: 0, status: 'wrong'});
	});
	
	// Utility

	function answer(result) {
		return wrapper.find("a[data-answer='" + result + "']");
	}
});