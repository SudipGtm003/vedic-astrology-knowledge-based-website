-- ============================================================================
--  Seed Content : Graha (9 planets)
--  Run AFTER schema.sql AND seed_topics.sql
-- ============================================================================

USE vedic_astrology_learn;

INSERT INTO topics (id, category_id, slug, sanskrit_name, name_en, name_np, sort_order, is_published) VALUES
(21,3,'surya','Surya','Sun','सूर्य',1,1),
(22,3,'chandra','Chandra','Moon','चन्द्र',2,1),
(23,3,'mangala','Mangala','Mars','मङ्गल',3,1),
(24,3,'budha','Budha','Mercury','बुध',4,1),
(25,3,'guru','Brihaspati','Jupiter','गुरु',5,1),
(26,3,'shukra','Shukra','Venus','शुक्र',6,1),
(27,3,'shani','Shani','Saturn','शनि',7,1),
(28,3,'rahu','Rahu','Rahu (North Node)','राहु',8,1),
(29,3,'ketu','Ketu','Ketu (South Node)','केतु',9,1);

INSERT INTO topic_content (topic_id, summary_np, summary_en, characteristics, effects, classical_reference, sanskrit_term, sanskrit_meaning) VALUES
(21,'सूर्य ज्योतिषको राजा हो। यसले आत्मा, पिता, अधिकार, आत्मविश्वास र सम्मानलाई जनाउँछ। जन्मकुण्डलीमा बलियो सूर्यले नेतृत्व गुण र ख्याति दिन्छ।','The Sun is the king of the zodiac. It signifies the soul, father, authority, self-confidence and honour. A strong Sun in the chart gives leadership qualities and reputation.',
'1. आत्मबल र आत्मविश्वास
2. नेतृत्व गुण र प्रशासनिक क्षमता
3. पितासँगको सम्बन्ध
4. सरकार, राज्य र सम्मानसँग सम्बन्ध
5. अहंकार र क्रोध पनि सूर्यबाट आउँछ','1. पद र प्रतिष्ठामा वृद्धि
2. स्वास्थ्य र ऊर्जामा बल
3. सरकारी काममा सफलता
4. अहंकारले विवाद
5. हृदय र आँखामा सावधानी','Brihat Parashara Hora Shastra, Adhyaya 2 (Graha Phala)','सूर्य','तेज — प्रकाश र आत्मा'),
(22,'चन्द्र मनको कारक हो। यसले भावना, माता, जल, शान्ति र सार्वजनिक लोकप्रियतालाई जनाउँछ। चन्द्र दुर्बल भए मन चञ्चल र चिन्ताग्रस्त हुन्छ।','The Moon is the significator of the mind. It represents emotions, the mother, water, peace and public popularity. A weak Moon makes the mind restless and anxious.',
'1. मनको भावना र संवेदनशीलता
2. मातासँगको सम्बन्ध
3. लोकप्रियता र जनसम्पर्क
4. सम्झना शक्ति र कल्पनाशक्ति
5. सपना र अनुभूतिसँग सम्बन्ध','1. मनको शान्ति र भावनात्मक सुख
2. माताको स्नेह र सहयोग
3. कला र सृजनात्मकतामा उत्कृष्टता
4. चिन्ता र अनिद्रा
5. जलसँग सम्बन्धित यात्रा','Brihat Parashara Hora Shastra, Adhyaya 3 (Chandra Phala)','चन्द्र','चन्द्र — जल र मन'),
(23,'मङ्गल भूमिपुत्र र सेनापतिको कारक हो। यसले साहस, शक्ति, भाइ, मित्र र भूमिसँग सम्बन्ध देखाउँछ। मङ्गल अशुभ भए विवाद, चोट र क्रोधले पीडा दिन्छ।','Mars is the son of the Earth and the commander. It signifies courage, strength, siblings, friends and land. Afflicted Mars brings disputes, injuries and anger.',
'1. साहस, ऊर्जा र शारीरिक बल
2. भाइबहिनी र मित्रसँगको सम्बन्ध
3. भूमि, अस्त्र र इन्जिनियरिङ
4. प्रतिस्पर्धा र जित्ने भावना
5. क्रोध र दुर्घटनाको प्रवृत्ति','1. पराक्रम र विजय
2. भूमि र निर्माणमा लाभ
3. सुरक्षा र सेनामा सफलता
4. चोट र सर्जरी
5. विवाद र कानूनी झगडा','Brihat Parashara Hora Shastra, Adhyaya 6 (Mangala Phala)','मङ्गल','रक्त — साहस र युद्ध'),
(24,'बुध बुद्धि, वाणी, व्यापार र लेखनको कारक हो। यसले तर्कशक्ति, सञ्चार क्षमता र गणितज्ञानलाई जनाउँछ। बुध मित्र र शत्रु दुवैको ग्रह हो।','Mercury is the significator of intellect, speech, commerce and writing. It indicates reasoning, communication ability and mathematics. Mercury can be both friend and foe.',
'1. बुद्धि र तर्कशक्ति
2. भाषा, लेखन र सञ्चार कला
3. व्यापार, गणित र लेखा
4. छोटा यात्रा र मित्र वृद्धि
5. शिक्षा र ज्ञान प्राप्ति','1. बौद्धिक विकास र शिक्षा
2. व्यापारमा चतुराई
3. वाणीमा प्रभावकारिता
4. शंका र द्विधा अवस्था
5. चालाकी अत्यधिक भए कठिनाइ','Brihat Parashara Hora Shastra, Adhyaya 10 (Budha Phala)','बुध','बुद्धि — वाणी र व्यापार'),
(25,'गुरु ज्ञान, धर्म, सन्तान र शिक्षाको कारक हो। यसलाई देवगुरु मानिन्छ र यो सर्वोत्तम ग्रह हो। गुरु बलियो भए भाग्य, आयु र सम्मान वृद्धि हुन्छ।','Jupiter is the significator of knowledge, dharma, children and education. Known as the divine teacher, it is regarded as the best of the planets. A strong Jupiter increases fortune, longevity and honour.',
'1. धर्म, नीति र नैतिकता
2. गुरु, शिक्षक र विद्यासँग सम्बन्ध
3. सन्तान र परिवारको सुख
4. धन, आयु र सम्मान
5. शिक्षा, वकालत र प्रवचन क्षेत्र','1. भाग्य र ज्ञानमा वृद्धि
2. सन्तानको शिक्षा र सफलता
3. गुरु र विद्याको लाभ
4. अति उदारताले धन ह्रास
5. शरीरमा वसा बढ्ने समस्या','Brihat Parashara Hora Shastra, Adhyaya 11 (Guru Phala)','गुरु','ज्ञान — देवगुरु र धर्म'),
(26,'शुक्र कला, सुन्दरता, वैवाहिक सुख र विलासिताको कारक हो। यसले स्त्री, भोग, संगीत र वाणिज्यलाई जनाउँछ।','Venus is the significator of art, beauty, marital happiness and luxury. It represents women, enjoyment, music and commerce.',
'1. कला, संगीत र सौन्दर्य
2. वैवाहिक सुख र प्रेम
3. विलासिता र भोगविलास
4. स्त्री, सजिलो जीवन र साथी
5. रंग, रेशम र अलङ्कार','1. प्रेम र वैवाहिक सुख
2. कलात्मक उत्कृष्टता
3. भौतिक सुख र विलासिता
4. अत्यधिक सुखमा आलस्य
5. शुक्रबारमा लाभ प्राप्ति','Brihat Parashara Hora Shastra, Adhyaya 13 (Shukra Phala)','शुक्र','मधु — सुख र सौन्दर्य'),
(27,'शनि कर्म, न्याय, श्रम र अनुशासनको कारक हो। यसलाई न्यायाधीश मानिन्छ। शनि धीमा तर शक्तिशाली ग्रह हो — यसले ढिलो तर टिकाउ फल दिन्छ।','Saturn is the significator of karma, justice, labour and discipline. It is regarded as the judge. Saturn is slow but powerful, giving delayed yet durable results.',
'1. श्रम, अनुशासन र धैर्य
2. न्याय र नियममा विश्वास
3. दरिद्रता र संघर्षको अनुभव
4. शनि एकादश, दशम र द्वादश भाव लगाउँछ
5. सेवा र श्रम क्षेत्रमा सफलता','1. कठिन परिश्रमपछि सफलता
2. अनुशासन र निर्णय क्षमता
3. विदेश र भूमिसँग सम्बन्ध
4. हड्डी र जोर्नीमा पीडा
5. सानो उमेरमा कठिनाइ, जेठैले सुधार','Brihat Parashara Hora Shastra, Adhyaya 15 (Shani Phala)','शनि','काल — समय र न्याय'),
(28,'राहु अन्धकारको ग्रह हो र छायामय ग्रहमध्ये एक हो। यसले विदेश, अन्तरिक्ष, तक्नोलोजी, भय र अचानक घटनालाई जनाउँछ।','Rahu is the planet of darkness and one of the shadow planets. It signifies foreign lands, technology, fear and sudden events.',
'1. अचानक घटना र अप्रत्याशित परिवर्तन
2. विदेश, अन्तरिक्ष र तक्नोलोजी
3. इच्छा, भय र मोह
4. छाया ग्रहका कारण विस्तार
5. भूत, प्रेत र गूढ विद्यासँग सम्बन्ध','1. विदेशमा अवसर र उन्नति
2. तक्नोलोजी र विज्ञानमा दक्षता
3. भ्रम र अन्धविश्वास
4. चोट र अचानक दुर्घटना
5. माया-मोहमा बाँकी रहने','Brihat Parashara Hora Shastra, Adhyaya 17 (Rahu Phala)','राहु','सर्पमुण्ड — मोह र विस्तार'),
(29,'केतु मोक्ष र आध्यात्मिकताको ग्रह हो। यसले पूर्वजन्मको कर्म, वैराग्य र ज्ञानलाई जनाउँछ। केतुले भौतिक कुरामा कम र आध्यात्ममा बढी रुचि दिलाउँछ।','Ketu is the planet of moksha and spirituality. It signifies past-life karma, detachment and knowledge. Ketu reduces interest in material life while increasing spiritual inclination.',
'1. पूर्वजन्मको कर्म र संस्कार
2. वैराग्य र आध्यात्मिक झुकाव
3. गूढ ज्ञान र अनुसन्धान
4. आध्यात्मिक गुरु र शिक्षा
5. मोक्ष र मुक्तिको दिशा','1. आध्यात्मिक उन्नति र ज्ञान
2. अचानक ज्ञान प्राप्ति
3. त्याग र वैराग्यको भाव
4. भौतिक कुरामा असफलता
5. चोट र विच्छेद सँग सम्बन्ध','Brihat Parashara Hora Shastra, Adhyaya 18 (Ketu Phala)','केतु','सर्पमुण्ड — मुक्ति र वैराग्य');

INSERT INTO topic_remedies (topic_id, remedy_np, remedy_en, sort_order) VALUES
(21,'सूर्यलाई जल अर्पण गर्ने र रविवार लाल वस्त्र लगाउने।','Offer water to the Sun and wear red on Sundays.',1),
(22,'चन्द्रलाई शान्ति गर्न शिवलिंगमा जल चढाउने।','Offer water to a Shiva linga to calm the Moon.',1),
(23,'मङ्गलबार मङ्गल ग्रहका मन्त्र जप्ने।','Chant the Mars mantra on Tuesdays.',1),
(24,'बुधवार गायलाई हरियो घाँस खुवाउने।','Feed green grass to a cow on Wednesdays.',1),
(25,'गुरुवार पीलो वस्त्र लगाउने र ब्राह्मणलाई दान दिने।','Wear yellow on Thursdays and give charity to a Brahmin.',1),
(26,'शुक्रबार शिवलिंगमा दूध चढाउने।','Offer milk to a Shiva linga on Fridays.',1),
(27,'शनिवार शनि मन्त्र जप्ने र तिल तेल दान गर्ने।','Chant the Saturn mantra on Saturdays and donate sesame oil.',1),
(28,'राहुलाई शान्ति गर्न दुर्गा सप्तशतीको पाठ गर्ने।','Recite Durga Saptashati to calm Rahu.',1),
(29,'केतुलाई शान्ति गर्न गणेश चालीसाको पाठ गर्ने।','Recite Ganesh Chalisa to calm Ketu.',1);
