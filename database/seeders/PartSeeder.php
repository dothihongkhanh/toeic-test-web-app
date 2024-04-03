<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parts')->insert([
            [
                'name_part' => 'Part 1',
                'direction' => 'For each question in this part, you will hear four statements about a picture in your test book. When you hear the statements, you must select the one statement that best describes what you see in the picture. Then find the number of the question on your answer sheet and mark your answer. The statements will not be printed in your test book and will be spoken only one time.',
                'desc' => 'Picture Description',
                'number_question' => 6,
            ],

            [
                'name_part' => 'Part 2',
                'direction' => 'You will hear a question or statement and three responses spoken in English. They will not be printed in your test book and will be spoken only one time. Select the best response to the question or statement and mark the letter ( A ),( B ), or ( C ) on your answer sheet.',
                'desc' => 'Question - Response',
                'number_question' => 25,
            ],
            [
                'name_part' => 'Part 3',
                'direction' => 'You will hear some conversations between two or more people. You will be asked to answer three questions about what the speakers say in each conversation. Select the best response to each question and mark the letter (A), (B), (C), or (D) on your answer sheet. The conversations will not be printed in your test book and will be spoken only one time.',
                'desc' => 'Short Conversations',
                'number_question' => 39,
            ],
            [
                'name_part' => 'Part 4',
                'direction' => 'You will hear some talks given by a single speaker. You will be asked to answer three questions about what the speaker says in each talk. Select the best response to each question and mark the letter (A), (B), (C), or (D) on your answer sheet. The talks will not be printed in your test book and will be spoken only one time.',
                'desc' => 'Talks',
                'number_question' => 30,
            ],
            [
                'name_part' => 'Part 5',
                'direction' => 'A word or phrase is missing in each of the sentences below. Four answer choices are given below each sentence. Select the best answer to complete the sentence. Then mark the letter',
                'desc' => 'Incomplete Sentences',
                'number_question' => 30,
            ],
            [
                'name_part' => 'Part 6',
                'direction' => 'Read the texts that follow. A word, phrase, or sentence is missing in parts of each text. Four answer choices for each question are given below the text. Select the best answer to complete the text. Then choose  the letter (A), (B), (C) or (D) .choose the one word or phrase that best completes the sentence',
                'desc' => 'Text Completion',
                'number_question' => 16,
            ],
            [
                'name_part' => 'Part 7',
                'direction' => 'In this part you will read a selection of texts, such as magazine and newspaper articles, e-mails, and instant messages. Each text or set of texts is followed by several questions. Select the best answer for each question and mark the letter (A), (B), (C), or (D) on your answer sheet.',
                'desc' => 'Reading Comprehension',
                'number_question' => 54,
            ],
        ]);
    }
}
