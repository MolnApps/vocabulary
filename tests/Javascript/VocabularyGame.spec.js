import { mount } from '@vue/test-utils';
import expect from 'expect';
import VocabularyGame from '../../resources/assets/js/components/VocabularyGame.vue';
import VocabularyGameQuestion from '../../resources/assets/js/components/VocabularyGameQuestion.vue';

describe ('VocabularyGame', () => {
	
	let wrapper; 

	beforeEach(() => {
		wrapper = mount(VocabularyGame, {
			stubs: {
				VocabularyGameQuestion: '<div class="question"></div>'
			},
			propsData: {
				'words': [
					{word: 'Hello', pronounce: 'Ciao', translation: 'Ciao'}
				],
				'options': [
					[
						{word: 'Hello', pronounce: 'Ciao', translation: 'Ciao'},
						{word: 'Man', pronounce: 'Uomo', translation: 'Uomo'},
						{word: 'Woman', pronounce: 'Donna', translation: 'Donna'}
					]
				]
			}
		});
	})
	
	it ('renders a word and some options', () => {
		expect(wrapper.findAll('.question').length).toBe(1);
	});

	it ('shows the new game button only at the end of the game', () => {
		let button = wrapper.find('.vocabulary-new-game');
		
		expect(button.isVisible()).toBe(false);

		giveAnswer();

		expect(button.isVisible()).toBe(true);
	});
	
	it ('updates the counter if the answer is correct', () => {
		let counter = wrapper.find('.vocabulary-counter');
		
		expect(counter.text()).toBe('0 / 1');

		giveAnswer('correct');

		expect(counter.text()).toBe('1 / 1');
	});
	
	it ('it does not update the counter if the answer is wrong', () => {
		let counter = wrapper.find('.vocabulary-counter');

		expect(counter.text()).toBe('0 / 1');

		giveAnswer('wrong');

		expect(counter.text()).toBe('0 / 1');
	});

	// Utility

	function giveAnswer(status = 'correct')
	{
		wrapper.setData({
			givenAnswers: [
				{index: 0, status: status}
			]
		});
	}
});